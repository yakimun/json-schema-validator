<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\ArrayTypeKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\StringTypeKeywordHandler;

final class TypeKeyword implements Keyword
{
    private const NAME = 'type';

    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param JsonPointer $path
     * @param SchemaContext $context
     */
    public function process(array $properties, JsonPointer $path, SchemaContext $context): void
    {
        $property = $properties[self::NAME];
        $keywordIdentifier = $context->getIdentifier()->addTokens(self::NAME);

        if ($property instanceof JsonString) {
            $type = $this->getType($property, $path);
            $context->addKeywordHandler(new StringTypeKeywordHandler((string)$keywordIdentifier, $type));

            return;
        }

        if ($property instanceof JsonArray) {
            $types = $this->getTypes($property, $path);
            $context->addKeywordHandler(new ArrayTypeKeywordHandler((string)$keywordIdentifier, $types));

            return;
        }

        $message = sprintf('Value must be either string or array at "%s"', (string)$path->addTokens(self::NAME));
        throw new InvalidSchemaException($message);
    }

    /**
     * @param JsonString $property
     * @return 'null'|'boolean'|'object'|'array'|'number'|'string'|'integer'
     */
    private function getType(JsonString $property, JsonPointer $path): string
    {
        $type = $property->getValue();

        if (!in_array($type, ['null', 'boolean', 'object', 'array', 'number', 'string', 'integer'], true)) {
            $format = 'Value must be equal to "null", "boolean", "object", "array", "number", "string", or "integer" '
                . 'at "%s"';
            throw new InvalidSchemaException(sprintf($format, (string)$path->addTokens(self::NAME)));
        }

        return $type;
    }

    /**
     * @param JsonArray $property
     * @param JsonPointer $path
     * @return list<'null'|'boolean'|'object'|'array'|'number'|'string'|'integer'>
     */
    private function getTypes(JsonArray $property, JsonPointer $path): array
    {
        $keywordPath = $path->addTokens(self::NAME);

        $types = [];
        $existingPaths = [];

        foreach ($property->getItems() as $index => $item) {
            $itemPath = $keywordPath->addTokens((string)$index);

            if (!$item instanceof JsonString) {
                throw new InvalidSchemaException(sprintf('Element must be string at "%s"', (string)$itemPath));
            }

            $type = $this->getType($item, $path);
            $existingPath = $existingPaths[$type] ?? null;

            if ($existingPath) {
                $format = 'Elements must be unique at "%s" and "%s"';
                throw new InvalidSchemaException(sprintf($format, (string)$existingPath, (string)$itemPath));
            }

            $types[] = $type;
            $existingPaths[$type] = $itemPath;
        }

        return $types;
    }
}
