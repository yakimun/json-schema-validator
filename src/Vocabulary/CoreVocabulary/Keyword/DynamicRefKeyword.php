<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\UriResolver;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaReference;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordHandler\DynamicRefKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class DynamicRefKeyword implements Keyword
{
    private const NAME = '$dynamicRef';

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
        $property = $properties[self::NAME];
        $keywordPath = $path->addTokens(self::NAME);

        if (!$property instanceof JsonString) {
            throw new InvalidSchemaException(sprintf('Value must be string at "%s"', (string)$keywordPath));
        }

        $identifier = $context->getIdentifier();
        $keywordIdentifier = $identifier->addTokens(self::NAME);

        $dynamicRef = UriResolver::resolve($identifier->getUri(), new Uri($property->getValue()));

        $context->addReference(new SchemaReference($dynamicRef, $keywordPath));
        $context->addKeywordHandler(new DynamicRefKeywordHandler((string)$keywordIdentifier, (string)$dynamicRef));
    }
}
