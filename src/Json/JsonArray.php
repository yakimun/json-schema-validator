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
    private array $elements;

    /**
     * @param list<JsonValue> $elements
     */
    public function __construct(array $elements)
    {
        $this->elements = $elements;
    }

    /**
     * @return list<JsonValue>
     */
    public function getElements(): array
    {
        return $this->elements;
    }

    /**
     * @param JsonValue $value
     * @return bool
     */
    public function equals(JsonValue $value): bool
    {
        if (!$value instanceof self || count($this->elements) !== count($value->elements)) {
            return false;
        }

        foreach ($this->elements as $index => $element) {
            if (!$element->equals($value->elements[$index])) {
                return false;
            }
        }

        return true;
    }
}
