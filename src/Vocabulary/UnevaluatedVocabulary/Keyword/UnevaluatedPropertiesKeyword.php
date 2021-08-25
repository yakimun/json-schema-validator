<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\KeywordValidator\UnevaluatedPropertiesKeywordValidator;

final class UnevaluatedPropertiesKeyword implements Keyword
{
    public const NAME = 'unevaluatedProperties';

    /**
     * @param non-empty-array<string, mixed> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $validator = $context->createValidator($properties[self::NAME], self::NAME);
        $context->addKeywordValidator(new UnevaluatedPropertiesKeywordValidator($validator));
    }
}
