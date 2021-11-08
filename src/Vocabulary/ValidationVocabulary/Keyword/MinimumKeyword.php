<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Json\JsonFloat;
use Yakimun\JsonSchemaValidator\Json\JsonInteger;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatMinimumKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntMinimumKeywordValidator;

final class MinimumKeyword implements Keyword
{
    public const NAME = 'minimum';

    /**
     * @param JsonValue $property
     * @param SchemaContext $context
     */
    public function process(JsonValue $property, SchemaContext $context): void
    {
        if ($property instanceof JsonInteger) {
            $context->addKeywordValidator(new IntMinimumKeywordValidator($property->getValue()));

            return;
        }

        if ($property instanceof JsonFloat) {
            $context->addKeywordValidator(new FloatMinimumKeywordValidator($property->getValue()));

            return;
        }

        throw $context->createException('The value must be a number.', self::NAME);
    }
}
