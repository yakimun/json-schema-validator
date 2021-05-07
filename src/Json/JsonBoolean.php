<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Json;

use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\ProcessedSchema;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaValidator\BooleanSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

/**
 * @psalm-immutable
 */
final class JsonBoolean implements JsonValue
{
    /**
     * @var bool
     */
    private $value;

    /**
     * @var JsonPointer
     */
    private $path;

    /**
     * @param bool $value
     * @param JsonPointer $path
     */
    public function __construct(bool $value, JsonPointer $path)
    {
        $this->value = $value;
        $this->path = $path;
    }

    /**
     * @return bool
     */
    public function getValue(): bool
    {
        return $this->value;
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
        return $value instanceof self && $this->value === $value->value;
    }

    /**
     * @param non-empty-array<string, Keyword> $keywords
     * @return non-empty-list<ProcessedSchema>
     */
    public function processAsSchema(SchemaIdentifier $identifier, array $keywords): array
    {
        $validator = new BooleanSchemaValidator((string)$identifier, $this->value);

        return [new ProcessedSchema($validator, $identifier, [], [], $this->path)];
    }
}
