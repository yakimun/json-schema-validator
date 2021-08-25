<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\ElseKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class ElseKeyword implements Keyword
{
    public const NAME = 'else';

    /**
     * @param non-empty-array<string, mixed> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $validator = $context->createValidator($properties[self::NAME], self::NAME);

        if (array_key_exists(IfKeyword::NAME, $properties)) {
            $context->addKeywordValidator(new ElseKeywordValidator($validator));
        }
    }
}
