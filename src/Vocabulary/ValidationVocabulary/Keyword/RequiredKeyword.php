<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\RequiredKeywordHandler;

final class RequiredKeyword implements Keyword
{
    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return 'required';
    }

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $property = $properties['required'];
        $identifier = (string)$context->getIdentifier()->addTokens('required');

        if (!$property instanceof JsonArray) {
            $message = sprintf('The value must be an array. Path: "%s".', (string)$property->getPath());
            throw new InvalidSchemaException($message);
        }

        $requiredProperties = [];
        $existingItems = [];

        foreach ($property->getItems() as $item) {
            if (!$item instanceof JsonString) {
                $message = sprintf('The element must be a string. Path: "%s".', (string)$item->getPath());
                throw new InvalidSchemaException($message);
            }

            $requiredProperty = $item->getValue();
            $existingItem = $existingItems[$requiredProperty] ?? null;

            if ($existingItem) {
                $format = 'The elements must be unique. Paths: "%s" and "%s".';
                $message = sprintf($format, (string)$existingItem->getPath(), (string)$item->getPath());
                throw new InvalidSchemaException($message);
            }

            $requiredProperties[] = $requiredProperty;
            $existingItems[$requiredProperty] = $item;
        }

        $context->addKeywordHandler(new RequiredKeywordHandler($identifier, $requiredProperties));
    }
}
