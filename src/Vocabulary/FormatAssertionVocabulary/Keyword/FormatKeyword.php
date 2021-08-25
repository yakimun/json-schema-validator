<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\FormatAssertionVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\FormatAssertionVocabulary\KeywordValidator\FormatKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class FormatKeyword implements Keyword
{
    public const NAME = 'format';

    /**
     * @param non-empty-array<string, mixed> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $property = $properties[self::NAME];

        if (!is_string($property)) {
            throw $context->createException('The value must be a string.', self::NAME);
        }

        $context->addKeywordValidator(new FormatKeywordValidator($property));
    }
}
