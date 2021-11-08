<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\FormatAnnotationVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\FormatAnnotationVocabulary\KeywordValidator\FormatKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class FormatKeyword implements Keyword
{
    public const NAME = 'format';

    /**
     * @param JsonValue $property
     * @param SchemaContext $context
     */
    public function process(JsonValue $property, SchemaContext $context): void
    {
        if (!$property instanceof JsonString) {
            throw $context->createException('The value must be a string.', self::NAME);
        }

        $context->addKeywordValidator(new FormatKeywordValidator($property->getValue()));
    }
}
