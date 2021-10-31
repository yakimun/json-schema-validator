<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatMaximumKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntMaximumKeywordValidator;

final class MaximumKeyword implements Keyword
{
    public const NAME = 'maximum';

    /**
     * @param list<mixed>|null|object|scalar $property
     * @param SchemaContext $context
     */
    public function process($property, SchemaContext $context): void
    {
        if (is_int($property)) {
            $context->addKeywordValidator(new IntMaximumKeywordValidator($property));

            return;
        }

        if (is_float($property)) {
            $context->addKeywordValidator(new FloatMaximumKeywordValidator($property));

            return;
        }

        throw $context->createException('The value must be a number.', self::NAME);
    }
}
