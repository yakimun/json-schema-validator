<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatExclusiveMaximumKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntExclusiveMaximumKeywordValidator;

final class ExclusiveMaximumKeyword implements Keyword
{
    public const NAME = 'exclusiveMaximum';

    /**
     * @param non-empty-array<string, mixed> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        /** @var scalar|object|list<mixed>|null $property */
        $property = $properties[self::NAME];

        if (is_int($property)) {
            $context->addKeywordValidator(new IntExclusiveMaximumKeywordValidator($property));

            return;
        }

        if (is_float($property)) {
            $context->addKeywordValidator(new FloatExclusiveMaximumKeywordValidator($property));

            return;
        }

        throw $context->createException('The value must be a number.', self::NAME);
    }
}
