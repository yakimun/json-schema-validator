<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MinContainsKeywordValidator;

final class MinContainsKeyword implements Keyword
{
    private const NAME = 'minContains';

    private const CONTAINS_NAME = 'contains';

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
        $property = $properties[self::NAME];

        if (!is_int($property)) {
            throw $context->createException('The value must be an integer.', self::NAME);
        }

        if ($property < 0) {
            throw $context->createException('The value must be a non-negative integer.', self::NAME);
        }

        if (array_key_exists(self::CONTAINS_NAME, $properties)) {
            $context->addKeywordValidator(new MinContainsKeywordValidator($property));
        }
    }
}
