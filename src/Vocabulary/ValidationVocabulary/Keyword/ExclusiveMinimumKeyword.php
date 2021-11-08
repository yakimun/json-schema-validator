<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Json\JsonFloat;
use Yakimun\JsonSchemaValidator\Json\JsonInteger;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatExclusiveMinimumKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntExclusiveMinimumKeywordValidator;

final class ExclusiveMinimumKeyword implements Keyword
{
    public const NAME = 'exclusiveMinimum';

    /**
     * @param JsonValue $property
     * @param SchemaContext $context
     */
    public function process(JsonValue $property, SchemaContext $context): void
    {
        if ($property instanceof JsonInteger) {
            $context->addKeywordValidator(new IntExclusiveMinimumKeywordValidator($property->getValue()));

            return;
        }

        if ($property instanceof JsonFloat) {
            $context->addKeywordValidator(new FloatExclusiveMinimumKeywordValidator($property->getValue()));

            return;
        }

        throw $context->createException('The value must be a number.', self::NAME);
    }
}
