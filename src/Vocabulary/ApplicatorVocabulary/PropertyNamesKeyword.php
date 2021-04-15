<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary;

use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\Schema\SchemaContext;
use Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier;
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
        $property = $properties['propertyNames'];

        $identifier = $context->getIdentifier();
        $uri = $identifier->getUri();
        $fragment = $identifier->getFragment();

        $propertyNamesIdentifier = new SchemaIdentifier($uri, $fragment->addTokens('propertyNames'));

        $schemaValidator = $context->createValidator($property, $propertyNamesIdentifier);
        $context->addKeywordHandler(new PropertyNamesKeywordHandler($schemaValidator));
    }
}
