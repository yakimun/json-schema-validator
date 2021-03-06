<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatMultipleOfKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntMultipleOfKeywordValidator;

final class MultipleOfKeyword implements Keyword
{
    private const NAME = 'multipleOf';

    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param non-empty-array<string, mixed> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        /** @var scalar|object|list<mixed>|null $property */
        $property = $properties[self::NAME];

        if (is_int($property)) {
            if ($property <= 0) {
                throw $context->createException('The value must be strictly greater than 0.', self::NAME);
            }

            $context->addKeywordValidator(new IntMultipleOfKeywordValidator($property));

            return;
        }

        if (is_float($property)) {
            if ($property <= 0) {
                throw $context->createException('The value must be strictly greater than 0.', self::NAME);
            }

            $context->addKeywordValidator(new FloatMultipleOfKeywordValidator($property));

            return;
        }

        throw $context->createException('The value must be a number.', self::NAME);
    }
}
