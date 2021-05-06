<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Json;

use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\ProcessedSchema;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaValidator\FalseSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

/**
 * @psalm-immutable
 */
final class JsonFalse implements JsonValue
{
    /**
     * @var JsonPointer
     */
    private $path;

    /**
     * @param JsonPointer $path
     */
    public function __construct(JsonPointer $path)
    {
        $this->path = $path;
    }

    /**
     * @return JsonPointer
     */
    public function getPath(): JsonPointer
    {
        return $this->path;
    }

    /**
     * @param JsonValue $value
     * @return bool
     */
    public function equals(JsonValue $value): bool
    {
        return $value instanceof self;
    }

    /**
     * @param non-empty-array<string, Keyword> $keywords
     * @return non-empty-list<ProcessedSchema>
     */
    public function processAsSchema(SchemaIdentifier $identifier, array $keywords): array
    {
        return [new ProcessedSchema(new FalseSchemaValidator((string)$identifier), $identifier, [], [], $this->path)];
    }
}
