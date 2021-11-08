<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\UriResolver;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class IdKeyword implements Keyword
{
    public const NAME = '$id';

    /**
     * @param JsonValue $property
     * @param SchemaContext $context
     */
    public function process(JsonValue $property, SchemaContext $context): void
    {
        if (!$property instanceof JsonString) {
            throw $context->createException('The value must be a string.', self::NAME);
        }

        $id = new Uri($property->getValue());

        if ($id->getFragment() !== '') {
            throw $context->createException('The value must resolve to an absolute URI.', self::NAME);
        }

        $context->setIdentifier(UriResolver::resolve($context->getIdentifier()->getUri(), $id), self::NAME);
    }
}
