<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\UriResolver;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator\RefKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class RefKeyword implements Keyword
{
    public const NAME = '$ref';

    /**
     * @param non-empty-array<string, mixed> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $property = $properties[self::NAME];

        if (!is_string($property)) {
            throw $context->createException('The value must be a string.', self::NAME);
        }

        $identifiers = $context->getIdentifiers();

        $ref = UriResolver::resolve(end($identifiers)->getUri(), new Uri($property));

        $context->addReference($ref, self::NAME);
        $context->addKeywordValidator(new RefKeywordValidator($ref));
    }
}
