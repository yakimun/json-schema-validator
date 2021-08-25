<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\AdditionalPropertiesKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class AdditionalPropertiesKeyword implements Keyword
{
    public const NAME = 'additionalProperties';

    /**
     * @param non-empty-array<string, mixed> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $validator = $context->createValidator($properties[self::NAME], self::NAME);
        $context->addKeywordValidator(new AdditionalPropertiesKeywordValidator($validator));
    }
}
