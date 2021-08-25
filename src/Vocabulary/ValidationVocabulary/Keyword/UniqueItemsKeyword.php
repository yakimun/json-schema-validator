<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\UniqueItemsKeywordValidator;

final class UniqueItemsKeyword implements Keyword
{
    public const NAME = 'uniqueItems';

    /**
     * @param non-empty-array<string, mixed> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $property = $properties[self::NAME];

        if (!is_bool($property)) {
            throw $context->createException('The value must be a boolean.', self::NAME);
        }

        $context->addKeywordValidator(new UniqueItemsKeywordValidator($property));
    }
}
