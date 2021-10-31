<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\KeywordValidator\UnevaluatedItemsKeywordValidator;

final class UnevaluatedItemsKeyword implements Keyword
{
    public const NAME = 'unevaluatedItems';

    /**
     * @param list<mixed>|null|object|scalar $property
     * @param SchemaContext $context
     */
    public function process($property, SchemaContext $context): void
    {
        $validator = $context->createValidator($property, self::NAME);
        $context->addKeywordValidator(new UnevaluatedItemsKeywordValidator($validator));
    }
}
