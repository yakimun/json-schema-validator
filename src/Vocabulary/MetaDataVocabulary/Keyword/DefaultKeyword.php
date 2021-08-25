<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\DefaultKeywordValidator;

final class DefaultKeyword implements Keyword
{
    public const NAME = 'default';

    /**
     * @param non-empty-array<string, mixed> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        /** @var scalar|object|list<mixed>|null $property */
        $property = $properties[self::NAME];

        $context->addKeywordValidator(new DefaultKeywordValidator($property));
    }
}
