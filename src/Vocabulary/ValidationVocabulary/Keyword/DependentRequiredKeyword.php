<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\DependentRequiredKeywordHandler;

final class DependentRequiredKeyword implements Keyword
{
    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return 'dependentRequired';
    }

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $property = $properties['dependentRequired'];
        $identifier = (string)$context->getIdentifier()->addTokens('dependentRequired');

        if (!$property instanceof JsonObject) {
            $message = sprintf('The value must be an object. Path: "%s".', (string)$property->getPath());
            throw new InvalidSchemaException($message);
        }

        $dependentRequiredProperties = [];

        foreach ($property->getProperties() as $key => $objectProperty) {
            if (!$objectProperty instanceof JsonArray) {
                $message = sprintf('The property must be an array. Path: "%s".', (string)$objectProperty->getPath());
                throw new InvalidSchemaException($message);
            }

            $dependentRequiredProperties[$key] = [];
            $existingItems = [];

            foreach ($objectProperty->getItems() as $item) {
                if (!$item instanceof JsonString) {
                    $message = sprintf('The property must be a string. Path: "%s".', (string)$item->getPath());
                    throw new InvalidSchemaException($message);
                }

                $dependentRequiredProperty = $item->getValue();
                $existingItem = $existingItems[$dependentRequiredProperty] ?? null;

                if ($existingItem) {
                    $format = 'The elements must be unique. Paths: "%s" and "%s".';
                    $message = sprintf($format, (string)$existingItem->getPath(), (string)$item->getPath());
                    throw new InvalidSchemaException($message);
                }

                $dependentRequiredProperties[$key][] = $dependentRequiredProperty;
                $existingItems[$dependentRequiredProperty] = $item;
            }
        }

        $context->addKeywordHandler(new DependentRequiredKeywordHandler($identifier, $dependentRequiredProperties));
    }
}
