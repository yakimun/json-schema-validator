<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\PropertyNamesKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class PropertyNamesKeyword implements Keyword
{
    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return 'propertyNames';
    }

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $identifier = $context->getIdentifier()->addTokens('propertyNames');
        $validator = $context->createValidator($properties['propertyNames'], $identifier);
        $context->addKeywordHandler(new PropertyNamesKeywordHandler((string)$identifier, $validator));
    }
}
