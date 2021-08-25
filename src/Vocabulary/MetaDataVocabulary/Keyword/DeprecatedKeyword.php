<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\DeprecatedKeywordValidator;

final class DeprecatedKeyword implements Keyword
{
    public const NAME = 'deprecated';

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

        $context->addKeywordValidator(new DeprecatedKeywordValidator($property));
    }
}
