<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\DependentRequiredKeywordHandler;

final class DependentRequiredKeyword implements Keyword
{
    private const NAME = 'dependentRequired';

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
        $keywordPath = $path->addTokens(self::NAME);

        if (!$property instanceof JsonObject) {
            throw new InvalidSchemaException(sprintf('Value must be object at "%s"', (string)$keywordPath));
        }

        $dependentRequiredProperties = [];

        foreach ($property->getProperties() as $key => $objectProperty) {
            $objectPropertyPath = $keywordPath->addTokens($key);

            if (!$objectProperty instanceof JsonArray) {
                $message = sprintf('Property must be array at "%s"', (string)$objectPropertyPath);
                throw new InvalidSchemaException($message);
            }

            $dependentRequiredProperties[$key] = [];
            $existingPaths = [];

            foreach ($objectProperty->getItems() as $index => $item) {
                $itemPath = $objectPropertyPath->addTokens((string)$index);

                if (!$item instanceof JsonString) {
                    throw new InvalidSchemaException(sprintf('Property must be string at "%s"', (string)$itemPath));
                }

                $dependentRequiredProperty = $item->getValue();
                $existingPath = $existingPaths[$dependentRequiredProperty] ?? null;

                if ($existingPath) {
                    $format = 'Elements must be unique at "%s" and "%s"';
                    throw new InvalidSchemaException(sprintf($format, (string)$existingPath, (string)$itemPath));
                }

                $dependentRequiredProperties[$key][] = $dependentRequiredProperty;
                $existingPaths[$dependentRequiredProperty] = $itemPath;
            }
        }

        $keywordIdentifier = $context->getIdentifier()->addTokens(self::NAME);

        $keywordHandler = new DependentRequiredKeywordHandler((string)$keywordIdentifier, $dependentRequiredProperties);
        $context->addKeywordHandler($keywordHandler);
    }
}
