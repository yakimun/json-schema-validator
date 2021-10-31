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
final class SchemaKeyword implements Keyword
{
    public const NAME = '$schema';

    /**
     * @param list<mixed>|null|object|scalar $property
     * @param SchemaContext $context
     */
    public function process($property, SchemaContext $context): void
    {
        if (!$context->getIdentifier()->getFragment()->isEmpty()) {
            $message = 'The keyword must not appear in non-resource root schema objects.';
            throw $context->createException($message, self::NAME);
        }

        if (!is_string($property)) {
            throw $context->createException('The value must be a string.', self::NAME);
        }

        $schema = new Uri($property);

        if ($schema->getScheme() === '') {
            throw $context->createException('The value must be a URI.', self::NAME);
        }

        /**
         * @psalm-suppress ImpureMethodCall
         */
        if ($schema !== UriNormalizer::normalize($schema)) {
            throw $context->createException('The value must be a normalized URI.', self::NAME);
        }
    }
}
