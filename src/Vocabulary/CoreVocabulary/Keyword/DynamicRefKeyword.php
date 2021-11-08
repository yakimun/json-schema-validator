<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\UriResolver;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator\DynamicRefKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class DynamicRefKeyword implements Keyword
{
    public const NAME = '$dynamicRef';

    /**
     * @param JsonValue $property
     * @param SchemaContext $context
     */
    public function process(JsonValue $property, SchemaContext $context): void
    {
        if (!$property instanceof JsonString) {
            throw $context->createException('The value must be a string.', self::NAME);
        }

        $dynamicRef = UriResolver::resolve($context->getIdentifier()->getUri(), new Uri($property->getValue()));

        $context->addReference($dynamicRef, self::NAME);
        $context->addKeywordValidator(new DynamicRefKeywordValidator($dynamicRef));
    }
}
