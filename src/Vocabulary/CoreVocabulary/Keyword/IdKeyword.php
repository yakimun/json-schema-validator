<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\UriResolver;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class IdKeyword implements Keyword
{
    private const NAME = '$id';

    /**
     * @return string
     * @psalm-mutation-free
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
        $property = $properties[self::NAME];

        if (!is_string($property)) {
            throw $context->createException('The value must be a string.', self::NAME);
        }

        $id = new Uri($property);

        if ($id->getFragment() !== '') {
            throw $context->createException('The value must resolve to an absolute URI.', self::NAME);
        }

        $identifiers = $context->getIdentifiers();

        $context->addIdentifier(UriResolver::resolve(end($identifiers)->getUri(), $id), self::NAME);
    }
}
