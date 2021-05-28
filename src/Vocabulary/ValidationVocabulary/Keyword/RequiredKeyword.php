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
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\RequiredKeywordHandler;

final class RequiredKeyword implements Keyword
{
    private const NAME = 'required';

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

        if (!$property instanceof JsonArray) {
            $message = sprintf('The value must be an array. Path: "%s".', (string)$keywordPath);
            throw new InvalidSchemaException($message);
        }

        $requiredProperties = [];
        $existingPaths = [];

        foreach ($property->getItems() as $index => $item) {
            $itemPath = $keywordPath->addTokens((string)$index);

            if (!$item instanceof JsonString) {
                $message = sprintf('The element must be a string. Path: "%s".', (string)$itemPath);
                throw new InvalidSchemaException($message);
            }

            $requiredProperty = $item->getValue();
            $existingPath = $existingPaths[$requiredProperty] ?? null;

            if ($existingPath) {
                $format = 'The elements must be unique. Paths: "%s" and "%s".';
                throw new InvalidSchemaException(sprintf($format, (string)$existingPath, (string)$itemPath));
            }

            $requiredProperties[] = $requiredProperty;
            $existingPaths[$requiredProperty] = $itemPath;
        }

        $keywordIdentifier = $context->getIdentifier()->addTokens(self::NAME);

        $context->addKeywordHandler(new RequiredKeywordHandler((string)$keywordIdentifier, $requiredProperties));
    }
}
