<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary;

use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\Schema\SchemaContext;
use Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class ThenKeyword implements Keyword
{
    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return 'then';
    }

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        if ($properties['if'] ?? null) {
            return;
        }

        $property = $properties['then'];

        $identifier = $context->getIdentifier();
        $thenIdentifier = new SchemaIdentifier($identifier->getUri(), $identifier->getFragment()->addTokens('then'));
        $context->createValidator($property, $thenIdentifier);
    }
}
