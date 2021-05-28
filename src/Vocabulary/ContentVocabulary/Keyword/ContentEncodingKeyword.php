<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordHandler\ContentEncodingKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class ContentEncodingKeyword implements Keyword
{
    private const NAME = 'contentEncoding';

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

        if (!$property instanceof JsonString) {
            $message = sprintf('The value must be a string. Path: "%s".', (string)$path->addTokens(self::NAME));
            throw new InvalidSchemaException($message);
        }

        $keywordIdentifier = $context->getIdentifier()->addTokens(self::NAME);

        $keywordHandler = new ContentEncodingKeywordHandler((string)$keywordIdentifier, $property->getValue());
        $context->addKeywordHandler($keywordHandler);
    }
}
