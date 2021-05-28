<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary;

use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;

interface Keyword
{
    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string;

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param JsonPointer $path
     * @param SchemaContext $context
     */
    public function process(array $properties, JsonPointer $path, SchemaContext $context): void;
}
