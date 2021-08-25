<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary;

use Yakimun\JsonSchemaValidator\SchemaContext;

interface Keyword
{
    /**
     * @param non-empty-array<string, mixed> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void;
}
