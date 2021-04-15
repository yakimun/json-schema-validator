<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary;

use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\Schema\SchemaContext;
use Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class ElseKeyword implements Keyword
{
    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return 'else';
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

        $property = $properties['else'];

        $identifier = $context->getIdentifier();
        $elseIdentifier = new SchemaIdentifier($identifier->getUri(), $identifier->getFragment()->addTokens('else'));
        $context->createValidator($property, $elseIdentifier);
    }
}
