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
final class JsonArray implements JsonValue
{
    /**
     * @var list<JsonValue>
     */
    private $items;

    /**
     * @var JsonPointer
     */
    private $path;

    /**
     * @param list<JsonValue> $items
     * @param JsonPointer $path
     */
    public function __construct(array $items, JsonPointer $path)
    {
        $this->items = $items;
        $this->path = $path;
    }

    /**
     * @return list<JsonValue>
     */
    public function getItems(): array
    {
        return $this->items;
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
        if (!$value instanceof self || count($this->items) !== count($value->items)) {
            return false;
        }

        foreach ($this->items as $index => $item) {
            if (!$item->equals($value->items[$index])) {
                return false;
            }
        }

        return true;
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
