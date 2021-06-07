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
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class IdKeyword implements Keyword
{
    private const NAME = '$id';

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

        if (!$property instanceof JsonString) {
            $message = sprintf('Value must be string at "%s"', (string)$path->addTokens(self::NAME));
            throw new InvalidSchemaException($message);
        }

        $id = new Uri($property->getValue());

        if ($id->getFragment() !== '') {
            $message = sprintf('Value must resolve to absolute URI at "%s"', (string)$path->addTokens(self::NAME));
            throw new InvalidSchemaException($message);
        }

        $uri = UriResolver::resolve($context->getIdentifier()->getUri(), $id);
        $context->setIdentifier(new SchemaIdentifier($uri, new JsonPointer()));
    }
}
