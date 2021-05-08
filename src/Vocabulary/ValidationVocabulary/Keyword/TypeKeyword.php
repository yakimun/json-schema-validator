<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\ArrayTypeKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\StringTypeKeywordHandler;

final class TypeKeyword implements Keyword
{
    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return 'type';
    }

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $property = $properties['type'];
        $identifier = (string)$context->getIdentifier()->addTokens('type');

        if ($property instanceof JsonString) {
            $context->addKeywordHandler(new StringTypeKeywordHandler($identifier, $this->getType($property)));

            return;
        }

        if ($property instanceof JsonArray) {
            $context->addKeywordHandler(new ArrayTypeKeywordHandler($identifier, $this->getTypes($property)));

            return;
        }

        $message = sprintf('The value must be either a string or an array. Path: "%s".', (string)$property->getPath());
        throw new InvalidSchemaException($message);
    }

    /**
     * @param JsonString $property
     * @return 'null'|'boolean'|'object'|'array'|'number'|'string'|'integer'
     */
    private function getType(JsonString $property): string
    {
        $type = $property->getValue();

        if (!in_array($type, ['null', 'boolean', 'object', 'array', 'number', 'string', 'integer'], true)) {
            $format = 'The value must be equal to "null", "boolean", "object", "array", "number", "string", or '
                . '"integer". Path: "%s".';
            throw new InvalidSchemaException(sprintf($format, (string)$property->getPath()));
        }

        return $type;
    }

    /**
     * @param JsonArray $property
     * @return list<'null'|'boolean'|'object'|'array'|'number'|'string'|'integer'>
     */
    private function getTypes(JsonArray $property): array
    {
        $types = [];
        $existingItems = [];

        foreach ($property->getItems() as $item) {
            if (!$item instanceof JsonString) {
                $message = sprintf('The element must be a string. Path: "%s".', (string)$item->getPath());
                throw new InvalidSchemaException($message);
            }

            $type = $this->getType($item);
            $existingItem = $existingItems[$type] ?? null;

            if ($existingItem) {
                $format = 'The elements must be unique. Paths: "%s" and "%s".';
                $message = sprintf($format, (string)$existingItem->getPath(), (string)$item->getPath());
                throw new InvalidSchemaException($message);
            }

            $types[] = $type;
            $existingItems[$type] = $item;
        }

        return $types;
    }
}
