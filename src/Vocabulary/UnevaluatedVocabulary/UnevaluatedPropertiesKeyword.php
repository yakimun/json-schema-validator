<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary;

use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\Schema\SchemaContext;
use Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class UnevaluatedPropertiesKeyword implements Keyword
{
    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return 'unevaluatedProperties';
    }

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $property = $properties['unevaluatedProperties'];

        $identifier = $context->getIdentifier();
        $uri = $identifier->getUri();
        $fragment = $identifier->getFragment();

        $unevaluatedPropertiesIdentifier = new SchemaIdentifier($uri, $fragment->addTokens('unevaluatedProperties'));

        $schemaValidator = $context->createValidator($property, $unevaluatedPropertiesIdentifier);
        $context->addKeywordHandler(new UnevaluatedPropertiesKeywordHandler($schemaValidator));
    }
}
