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
final class JsonInteger implements JsonValue
{
    /**
     * @var int
     */
    private $value;

    /**
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
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
     * @param SchemaIdentifier $identifier
     * @param non-empty-array<string, Keyword> $keywords
     * @param JsonPointer $path
     * @return non-empty-list<ProcessedSchema>
     */
    public function processAsSchema(SchemaIdentifier $identifier, array $keywords, JsonPointer $path): array
    {
        $message = sprintf('The schema must be an object or a boolean. Path: "%s".', (string)$path);
        throw new InvalidSchemaException($message);
    }
}
