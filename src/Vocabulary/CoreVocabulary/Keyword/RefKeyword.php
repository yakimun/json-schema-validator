<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\UriResolver;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaReference;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordHandler\RefKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class RefKeyword implements Keyword
{
    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return '$ref';
    }

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $property = $properties['$ref'];

        $path = $property->getPath();

        if (!$property instanceof JsonString) {
            throw new InvalidSchemaException(sprintf('The value must be a string. Path: "%s".', (string)$path));
        }

        $identifier = $context->getIdentifier();
        $refIdentifier = $identifier->addTokens('$ref');

        $ref = UriResolver::resolve($identifier->getUri(), new Uri($property->getValue()));

        $context->addReference(new SchemaReference($ref, $path));
        $context->addKeywordHandler(new RefKeywordHandler((string)$refIdentifier, (string)$ref));
    }
}
