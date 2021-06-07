<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\AnyOfKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class AnyOfKeyword implements Keyword
{
    private const NAME = 'anyOf';

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
            throw new InvalidSchemaException(sprintf('Value must be array at "%s"', (string)$keywordPath));
        }

        $items = $property->getItems();

        if (!$items) {
            throw new InvalidSchemaException(sprintf('Value must be non-empty array at "%s"', (string)$keywordPath));
        }

        $keywordIdentifier = $context->getIdentifier()->addTokens(self::NAME);
        $validators = [];

        foreach ($items as $index => $item) {
            $stringIndex = (string)$index;

            $itemIdentifier = $keywordIdentifier->addTokens($stringIndex);
            $itemPath = $keywordPath->addTokens($stringIndex);

            $validators[] = $context->createValidator($item, $itemIdentifier, $itemPath);
        }

        $context->addKeywordHandler(new AnyOfKeywordHandler((string)$keywordIdentifier, $validators));
    }
}
