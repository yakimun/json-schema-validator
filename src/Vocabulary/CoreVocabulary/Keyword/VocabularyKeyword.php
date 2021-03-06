<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\UriNormalizer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

/**
 * @psalm-immutable
 */
final class VocabularyKeyword implements Keyword
{
    private const NAME = '$vocabulary';

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param non-empty-array<string, mixed> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        if (!$context->getPath()->isEmpty()) {
            throw $context->createException('The keyword must not appear in subschemas.', self::NAME);
        }

        $property = $properties[self::NAME];

        if (!is_object($property)) {
            throw $context->createException('The value must be an object.', self::NAME);
        }

        foreach (get_object_vars($property) as $key => $value) {
            $uri = new Uri($key);

            if ($uri->getScheme() === '') {
                throw $context->createException('Property names in the object must be URIs.', self::NAME);
            }

            /**
             * @psalm-suppress ImpureMethodCall
             */
            if ($uri !== UriNormalizer::normalize($uri)) {
                throw $context->createException('Property names in the object must be normalized URIs.', self::NAME);
            }

            if (!is_bool($value)) {
                throw $context->createException('Object property values must be boolean.', self::NAME);
            }
        }
    }
}
