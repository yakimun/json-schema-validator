<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\UriNormalizer;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class SchemaKeyword implements Keyword
{
    public const NAME = '$schema';

    /**
     * @param JsonValue $property
     * @param SchemaContext $context
     */
    public function process(JsonValue $property, SchemaContext $context): void
    {
        if (!$context->getIdentifier()->getFragment()->isEmpty()) {
            $message = 'The keyword must not appear in non-resource root schema objects.';
            throw $context->createException($message, self::NAME);
        }

        if (!$property instanceof JsonString) {
            throw $context->createException('The value must be a string.', self::NAME);
        }

        $schema = new Uri($property->getValue());

        if ($schema->getScheme() === '') {
            throw $context->createException('The value must be a URI.', self::NAME);
        }

        if ($schema !== UriNormalizer::normalize($schema)) {
            throw $context->createException('The value must be a normalized URI.', self::NAME);
        }
    }
}
