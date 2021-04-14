<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary;

use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\UriResolver;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\Schema\SchemaContext;
use Yakimun\JsonSchemaValidator\Schema\SchemaReference;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class DynamicRefKeyword implements Keyword
{
    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return '$dynamicRef';
    }

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $property = $properties['$dynamicRef'];

        $path = $property->getPath();

        if (!$property instanceof JsonString) {
            throw new InvalidSchemaException(sprintf('The value must be a string. Path: "%s".', (string)$path));
        }

        $dynamicRef = UriResolver::resolve($context->getIdentifier()->getUri(), new Uri($property->getValue()));
        $context->addReference(new SchemaReference($dynamicRef, $path));
        $context->addKeywordHandler(new DynamicRefKeywordHandler($dynamicRef));
    }
}
