<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\ThenKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class ThenKeyword implements Keyword
{
    public const NAME = 'then';

    /**
     * @param non-empty-array<string, mixed> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $validator = $context->createValidator($properties[self::NAME], self::NAME);

        if (array_key_exists(IfKeyword::NAME, $properties)) {
            $context->addKeywordValidator(new ThenKeywordValidator($validator));
        }
    }
}
