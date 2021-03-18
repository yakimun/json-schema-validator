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
    private $properties;

    /**
     * @var JsonPointer
     */
    private $path;

    /**
     * @param array<string, JsonValue> $properties
     * @param JsonPointer $path
     */
    public function __construct(array $properties, JsonPointer $path)
    {
        $this->properties = $properties;
        $this->path = $path;
    }

    /**
     * @return array<string, JsonValue>
     */
    public function getProperties(): array
    {
        return $this->properties;
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