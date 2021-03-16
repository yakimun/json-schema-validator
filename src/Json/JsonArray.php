<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Json;

final class JsonArray implements JsonValue
{
    /**
     * @var JsonValue[]
     */
    private $items;

    /**
     * @var JsonPointer
     */
    private $path;

    /**
     * @param JsonValue[] $items
     * @param JsonPointer $path
     */
    public function __construct(array $items, JsonPointer $path)
    {
        $this->items = $items;
        $this->path = $path;
    }

    /**
     * @return JsonValue[]
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
