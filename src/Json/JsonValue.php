<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Json;

use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\ProcessedSchema;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

interface JsonValue
{
    /**
     * @return JsonPointer
     * @psalm-mutation-free
     */
    public function getPath(): JsonPointer;

    /**
     * @param JsonValue $value
     * @return bool
     * @psalm-mutation-free
     */
    public function equals(JsonValue $value): bool;

    /**
     * @param non-empty-array<string, Keyword> $keywords
     * @return non-empty-list<ProcessedSchema>
     */
    public function processAsSchema(SchemaIdentifier $identifier, array $keywords): array;
}
