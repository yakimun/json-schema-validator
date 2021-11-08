<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Json\JsonFloat;
use Yakimun\JsonSchemaValidator\Json\JsonInteger;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatMultipleOfKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntMultipleOfKeywordValidator;

final class MultipleOfKeyword implements Keyword
{
    public const NAME = 'multipleOf';

    /**
     * @param JsonValue $property
     * @param SchemaContext $context
     */
    public function process(JsonValue $property, SchemaContext $context): void
    {
        if ($property instanceof JsonInteger) {
            if ($property->getValue() <= 0) {
                throw $context->createException('The value must be strictly greater than 0.', self::NAME);
            }

            $context->addKeywordValidator(new IntMultipleOfKeywordValidator($property->getValue()));

            return;
        }

        if ($property instanceof JsonFloat) {
            if ($property->getValue() <= 0) {
                throw $context->createException('The value must be strictly greater than 0.', self::NAME);
            }

            $context->addKeywordValidator(new FloatMultipleOfKeywordValidator($property->getValue()));

            return;
        }

        throw $context->createException('The value must be a number.', self::NAME);
    }
}
