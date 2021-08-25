<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\NotKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class NotKeyword implements Keyword
{
    public const NAME = 'not';

    /**
     * @param non-empty-array<string, mixed> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $validator = $context->createValidator($properties[self::NAME], self::NAME);
        $context->addKeywordValidator(new NotKeywordValidator($validator));
    }
}
