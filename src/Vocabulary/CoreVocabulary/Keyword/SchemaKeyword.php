<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\UriNormalizer;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class SchemaKeyword implements Keyword
{
    private const NAME = '$schema';

    private const ID_NAME = '$id';

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

        $schema = new Uri($property->getValue());

        if ($schema->getScheme() === '') {
            $message = sprintf('Value must be URI at "%s"', (string)$path->addTokens(self::NAME));
            throw new InvalidSchemaException($message);
        }

        if ($schema !== UriNormalizer::normalize($schema)) {
            $message = sprintf('Value must be normalized URI at "%s"', (string)$path->addTokens(self::NAME));
            throw new InvalidSchemaException($message);
        }

        if (!($properties[self::ID_NAME] ?? null) && !$path->equals(new JsonPointer())) {
            $format = 'Keyword must not appear in non-resource root schema objects at "%s"';
            throw new InvalidSchemaException(sprintf($format, (string)$path->addTokens(self::NAME)));
        }
    }
}
