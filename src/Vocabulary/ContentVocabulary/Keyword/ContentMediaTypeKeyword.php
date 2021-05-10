<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordHandler\ContentMediaTypeKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class ContentMediaTypeKeyword implements Keyword
{
    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return 'contentMediaType';
    }

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $property = $properties['contentMediaType'];
        $identifier = (string)$context->getIdentifier()->addTokens('contentMediaType');

        if (!$property instanceof JsonString) {
            $message = sprintf('The value must be a string. Path: "%s".', (string)$property->getPath());
            throw new InvalidSchemaException($message);
        }

        $context->addKeywordHandler(new ContentMediaTypeKeywordHandler($identifier, $property->getValue()));
    }
}
