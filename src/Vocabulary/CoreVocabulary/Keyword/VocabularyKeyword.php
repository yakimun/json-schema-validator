<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\UriNormalizer;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonFalse;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonTrue;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class VocabularyKeyword implements Keyword
{
    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return '$vocabulary';
    }

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $property = $properties['$vocabulary'];

        $path = $property->getPath();

        if (!$property instanceof JsonObject) {
            throw new InvalidSchemaException(sprintf('The value must be an object. Path: "%s".', (string)$path));
        }

        foreach ($property->getProperties() as $key => $value) {
            $uri = new Uri($key);

            if ($uri->getScheme() === '') {
                $message = sprintf('The property names in the object must be URIs. Path: "%s".', (string)$path);
                throw new InvalidSchemaException($message);
            }

            if ($uri !== UriNormalizer::normalize($uri)) {
                $format = 'The property names in the object must be normalized URIs. Path: "%s".';
                throw new InvalidSchemaException(sprintf($format, (string)$path));
            }

            if (!$value instanceof JsonTrue && !$value instanceof JsonFalse) {
                $message = sprintf('The values of the object properties must be booleans. Path: "%s".', (string)$path);
                throw new InvalidSchemaException($message);
            }
        }

        if (!$path->equals(new JsonPointer('$vocabulary'))) {
            $message = sprintf('The keyword must not appear in subschemas. Path: "%s".', (string)$path);
            throw new InvalidSchemaException($message);
        }
    }
}
