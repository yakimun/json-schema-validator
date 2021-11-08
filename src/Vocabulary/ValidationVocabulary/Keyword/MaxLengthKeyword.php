<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Json\JsonInteger;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MaxLengthKeywordValidator;

final class MaxLengthKeyword implements Keyword
{
    public const NAME = 'maxLength';

    /**
     * @param JsonValue $property
     * @param SchemaContext $context
     */
    public function process(JsonValue $property, SchemaContext $context): void
    {
        if (!$property instanceof JsonInteger) {
            throw $context->createException('The value must be an integer.', self::NAME);
        }

        if ($property->getValue() < 0) {
            throw $context->createException('The value must be a non-negative integer.', self::NAME);
        }

        $context->addKeywordValidator(new MaxLengthKeywordValidator($property->getValue()));
    }
}
