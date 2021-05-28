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
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordHandler\RefKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class RefKeyword implements Keyword
{
    private const NAME = '$ref';

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
            throw new InvalidSchemaException(sprintf('The value must be a string. Path: "%s".', (string)$keywordPath));
        }

        $identifier = $context->getIdentifier();
        $keywordIdentifier = $identifier->addTokens(self::NAME);

        $ref = UriResolver::resolve($identifier->getUri(), new Uri($property->getValue()));

        $context->addReference(new SchemaReference($ref, $keywordPath));
        $context->addKeywordHandler(new RefKeywordHandler((string)$keywordIdentifier, (string)$ref));
    }
}
