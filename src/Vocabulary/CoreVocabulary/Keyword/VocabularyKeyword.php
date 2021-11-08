<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\UriNormalizer;
use Yakimun\JsonSchemaValidator\Json\JsonBoolean;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class VocabularyKeyword implements Keyword
{
    public const NAME = '$vocabulary';

    /**
     * @param JsonValue $property
     * @param SchemaContext $context
     */
    public function process(JsonValue $property, SchemaContext $context): void
    {
        if (!$context->getPath()->isEmpty()) {
            throw $context->createException('The keyword must not appear in subschemas.', self::NAME);
        }

        if (!$property instanceof JsonObject) {
            throw $context->createException('The value must be an object.', self::NAME);
        }

        foreach ($property->getProperties() as $key => $value) {
            $uri = new Uri($key);

            if ($uri->getScheme() === '') {
                throw $context->createException('Property names in the object must be URIs.', self::NAME);
            }

            if ($uri !== UriNormalizer::normalize($uri)) {
                throw $context->createException('Property names in the object must be normalized URIs.', self::NAME);
            }

            if (!$value instanceof JsonBoolean) {
                throw $context->createException('Object property values must be boolean.', self::NAME);
            }
        }
    }
}
