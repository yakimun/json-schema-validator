<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\KeywordHandler\UnevaluatedItemsKeywordHandler;

final class UnevaluatedItemsKeyword implements Keyword
{
    private const NAME = 'unevaluatedItems';

    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param JsonPointer $path
     * @param SchemaContext $context
     */
    public function process(array $properties, JsonPointer $path, SchemaContext $context): void
    {
        $keywordIdentifier = $context->getIdentifier()->addTokens(self::NAME);
        $keywordPath = $path->addTokens(self::NAME);

        $validator = $context->createValidator($properties[self::NAME], $keywordIdentifier, $keywordPath);
        $context->addKeywordHandler(new UnevaluatedItemsKeywordHandler((string)$keywordIdentifier, $validator));
    }
}
