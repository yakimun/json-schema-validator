<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Json;

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
}
