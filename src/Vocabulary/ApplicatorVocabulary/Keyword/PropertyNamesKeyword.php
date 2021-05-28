<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\PropertyNamesKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class PropertyNamesKeyword implements Keyword
{
    private const NAME = 'propertyNames';

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
        $context->addKeywordHandler(new PropertyNamesKeywordHandler((string)$keywordIdentifier, $validator));
    }
}
