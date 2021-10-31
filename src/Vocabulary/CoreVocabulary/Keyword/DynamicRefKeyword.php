<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\UriResolver;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator\DynamicRefKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class DynamicRefKeyword implements Keyword
{
    public const NAME = '$dynamicRef';

    /**
     * @param list<mixed>|null|object|scalar $property
     * @param SchemaContext $context
     */
    public function process($property, SchemaContext $context): void
    {
        if (!is_string($property)) {
            throw $context->createException('The value must be a string.', self::NAME);
        }

        $dynamicRef = UriResolver::resolve($context->getIdentifier()->getUri(), new Uri($property));

        $context->addReference($dynamicRef, self::NAME);
        $context->addKeywordValidator(new DynamicRefKeywordValidator($dynamicRef));
    }
}
