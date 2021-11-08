<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordValidator\ContentMediaTypeKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class ContentMediaTypeKeyword implements Keyword
{
    public const NAME = 'contentMediaType';

    /**
     * @param JsonValue $property
     * @param SchemaContext $context
     */
    public function process(JsonValue $property, SchemaContext $context): void
    {
        if (!$property instanceof JsonString) {
            throw $context->createException('The value must be a string.', self::NAME);
        }

        $context->addKeywordValidator(new ContentMediaTypeKeywordValidator($property->getValue()));
    }
}
