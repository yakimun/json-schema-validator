<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\UriNormalizer;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonBoolean;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class VocabularyKeyword implements Keyword
{
    private const NAME = '$vocabulary';

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

        if (!$property instanceof JsonObject) {
            $message = sprintf('Value must be object at "%s"', (string)$path->addTokens(self::NAME));
            throw new InvalidSchemaException($message);
        }

        foreach ($property->getProperties() as $key => $value) {
            $uri = new Uri($key);

            if ($uri->getScheme() === '') {
                $format = 'Property names in object must be URIs at "%s"';
                throw new InvalidSchemaException(sprintf($format, (string)$path->addTokens(self::NAME, $key)));
            }

            if ($uri !== UriNormalizer::normalize($uri)) {
                $format = 'Property names in object must be normalized URIs at "%s"';
                throw new InvalidSchemaException(sprintf($format, (string)$path->addTokens(self::NAME, $key)));
            }

            if (!$value instanceof JsonBoolean) {
                $format = 'Values of object properties must be booleans at "%s"';
                throw new InvalidSchemaException(sprintf($format, (string)$path->addTokens(self::NAME, $key)));
            }
        }

        if (!$path->equals(new JsonPointer())) {
            $message = sprintf('Keyword must not appear in subschemas at "%s"', (string)$path->addTokens(self::NAME));
            throw new InvalidSchemaException($message);
        }
    }
}
