<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordHandler\ContentEncodingKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class ContentEncodingKeyword implements Keyword
{
    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return 'contentEncoding';
    }

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $property = $properties['contentEncoding'];
        $identifier = (string)$context->getIdentifier()->addTokens('contentEncoding');

        if (!$property instanceof JsonString) {
            $message = sprintf('The value must be a string. Path: "%s".', (string)$property->getPath());
            throw new InvalidSchemaException($message);
        }

        $context->addKeywordHandler(new ContentEncodingKeywordHandler($identifier, $property->getValue()));
    }
}
