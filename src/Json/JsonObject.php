<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Json;

/**
 * @psalm-immutable
 */
final class JsonObject implements JsonValue
{
    /**
     * @var array<string, JsonValue>
     */
    private array $properties;

    /**
     * @param array<string, JsonValue> $properties
     */
    public function __construct(array $properties)
    {
        $this->properties = $properties;
    }

    /**
     * @return array<string, JsonValue>
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @param JsonValue $value
     * @return bool
     */
    public function equals(JsonValue $value): bool
    {
        if (!$value instanceof self || count($this->properties) !== count($value->properties)) {
            return false;
        }

        foreach ($this->properties as $key => $property) {
            if (!$property->equals($value->properties[$key])) {
                return false;
            }
        }

        return true;
    }
}
