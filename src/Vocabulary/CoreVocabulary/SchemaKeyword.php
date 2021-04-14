<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary;

use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\UriNormalizer;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonPointer;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\Schema\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class SchemaKeyword implements Keyword
{
    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return '$schema';
    }

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $property = $properties['$schema'];

        $path = $property->getPath();

        if (!$property instanceof JsonString) {
            throw new InvalidSchemaException(sprintf('The value must be a string. Path: "%s".', (string)$path));
        }

        $schema = new Uri($property->getValue());

        if ($schema->getScheme() === '') {
            throw new InvalidSchemaException(sprintf('The value must be a URI. Path: "%s".', (string)$path));
        }

        if ($schema !== UriNormalizer::normalize($schema)) {
            throw new InvalidSchemaException(sprintf('The value must be a normalized URI. Path: "%s".', (string)$path));
        }

        if (!$path->equals(new JsonPointer('$schema')) && !($properties['$id'] ?? null)) {
            $format = 'The keyword must not appear in non-resource root schema objects. Path: "%s".';
            throw new InvalidSchemaException(sprintf($format, (string)$path));
        }
    }
}
