<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\KeywordHandler\UnevaluatedItemsKeywordHandler;

final class UnevaluatedItemsKeyword implements Keyword
{
    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return 'unevaluatedItems';
    }

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $identifier = $context->getIdentifier()->addTokens('unevaluatedItems');
        $validator = $context->createValidator($properties['unevaluatedItems'], $identifier);
        $context->addKeywordHandler(new UnevaluatedItemsKeywordHandler((string)$identifier, $validator));
    }
}
