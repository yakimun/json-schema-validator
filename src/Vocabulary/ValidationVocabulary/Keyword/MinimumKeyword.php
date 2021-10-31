<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatMinimumKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntMinimumKeywordValidator;

final class MinimumKeyword implements Keyword
{
    public const NAME = 'minimum';

    /**
     * @param list<mixed>|null|object|scalar $property
     * @param SchemaContext $context
     */
    public function process($property, SchemaContext $context): void
    {
        if (is_int($property)) {
            $context->addKeywordValidator(new IntMinimumKeywordValidator($property));

            return;
        }

        if (is_float($property)) {
            $context->addKeywordValidator(new FloatMinimumKeywordValidator($property));

            return;
        }

        throw $context->createException('The value must be a number.', self::NAME);
    }
}
