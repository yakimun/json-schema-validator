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

        $format = 'The value must be either a string or an array. Path: "%s".';
        throw new InvalidSchemaException(sprintf($format, (string)$path->addTokens(self::NAME)));
    }

    /**
     * @param JsonString $property
     * @return 'null'|'boolean'|'object'|'array'|'number'|'string'|'integer'
     */
    private function getType(JsonString $property, JsonPointer $path): string
    {
        $type = $property->getValue();

        if (!in_array($type, ['null', 'boolean', 'object', 'array', 'number', 'string', 'integer'], true)) {
            $format = 'The value must be equal to "null", "boolean", "object", "array", "number", "string", or '
                . '"integer". Path: "%s".';
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
                $message = sprintf('The element must be a string. Path: "%s".', (string)$itemPath);
                throw new InvalidSchemaException($message);
            }

            $type = $this->getType($item, $path);
            $existingPath = $existingPaths[$type] ?? null;

            if ($existingPath) {
                $format = 'The elements must be unique. Paths: "%s" and "%s".';
                throw new InvalidSchemaException(sprintf($format, (string)$existingPath, (string)$itemPath));
            }

            $types[] = $type;
            $existingPaths[$type] = $itemPath;
        }

        return $types;
    }
}
