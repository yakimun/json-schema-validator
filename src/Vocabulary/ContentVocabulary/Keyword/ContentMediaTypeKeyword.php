<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordValidator\ContentMediaTypeKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class ContentMediaTypeKeyword implements Keyword
{
    public const NAME = 'contentMediaType';

    /**
     * @param list<mixed>|null|object|scalar $property
     * @param SchemaContext $context
     */
    public function process($property, SchemaContext $context): void
    {
        if (!is_string($property)) {
            throw $context->createException('The value must be a string.', self::NAME);
        }

        $context->addKeywordValidator(new ContentMediaTypeKeywordValidator($property));
    }
}
