<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordValidator\ContentEncodingKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class ContentEncodingKeyword implements Keyword
{
    public const NAME = 'contentEncoding';

    /**
     * @param non-empty-array<string, mixed> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $property = $properties[self::NAME];

        if (!is_string($property)) {
            throw $context->createException('The value must be a string.', self::NAME);
        }

        $context->addKeywordValidator(new ContentEncodingKeywordValidator($property));
    }
}
