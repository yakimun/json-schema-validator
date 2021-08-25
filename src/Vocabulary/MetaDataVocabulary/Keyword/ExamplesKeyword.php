<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\ExamplesKeywordValidator;

final class ExamplesKeyword implements Keyword
{
    public const NAME = 'examples';

    /**
     * @param non-empty-array<string, mixed> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $property = $properties[self::NAME];

        if (!is_array($property)) {
            throw $context->createException('The value must be an array.', self::NAME);
        }

        $context->addKeywordValidator(new ExamplesKeywordValidator(array_values($property)));
    }
}
