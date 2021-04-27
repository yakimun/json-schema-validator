<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Json;

use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\ProcessedSchema;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

/**
 * @psalm-immutable
 */
final class JsonString implements JsonValue
{
    /**
     * @var string
     */
    private $value;

    /**
     * @var JsonPointer
     */
    private $path;

    /**
     * @param string $value
     * @param JsonPointer $path
     */
    public function __construct(string $value, JsonPointer $path)
    {
        $this->value = $value;
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getValue(): string
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
        $message = sprintf('The schema must be an object or a boolean. Path: "%s".', (string)$this->path);
        throw new InvalidSchemaException($message);
    }
}
