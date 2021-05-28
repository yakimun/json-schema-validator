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
            $message = sprintf('The value must be an object. Path: "%s".', (string)$path->addTokens(self::NAME));
            throw new InvalidSchemaException($message);
        }

        foreach ($property->getProperties() as $key => $value) {
            $uri = new Uri($key);

            if ($uri->getScheme() === '') {
                $format = 'The property names in the object must be URIs. Path: "%s".';
                throw new InvalidSchemaException(sprintf($format, (string)$path->addTokens(self::NAME, $key)));
            }

            if ($uri !== UriNormalizer::normalize($uri)) {
                $format = 'The property names in the object must be normalized URIs. Path: "%s".';
                throw new InvalidSchemaException(sprintf($format, (string)$path->addTokens(self::NAME, $key)));
            }

            if (!$value instanceof JsonBoolean) {
                $format = 'The values of the object properties must be booleans. Path: "%s".';
                throw new InvalidSchemaException(sprintf($format, (string)$path->addTokens(self::NAME, $key)));
            }
        }

        if (!$path->equals(new JsonPointer())) {
            $format = 'The keyword must not appear in subschemas. Path: "%s".';
            throw new InvalidSchemaException(sprintf($format, (string)$path->addTokens(self::NAME)));
        }
    }
}
