<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Json;

/**
 * @psalm-immutable
 */
final class JsonValueConverter
{
    /**
     * @param null|scalar|object|list<mixed> $value
     * @return JsonValue
     */
    public function convert($value): JsonValue
    {
        return $this->convertValue($value, new JsonPointer());
    }

    /**
     * @param null|scalar|object|list<mixed> $value
     * @param JsonPointer $path
     * @return JsonValue
     */
    private function convertValue($value, JsonPointer $path): JsonValue
    {
        if (is_null($value)) {
            return new JsonNull($path);
        }

        if (is_bool($value)) {
            return $value ? new JsonTrue($path) : new JsonFalse($path);
        }

        if (is_object($value)) {
            return $this->convertObjectValue($value, $path);
        }

        if (is_array($value)) {
            return $this->convertArrayValue($value, $path);
        }

        if (is_int($value)) {
            return new JsonInteger($value, $path);
        }

        if (is_float($value)) {
            return new JsonFloat($value, $path);
        }

        return new JsonString($value, $path);
    }

    /**
     * @param object $value
     * @param JsonPointer $path
     * @return JsonObject
     */
    private function convertObjectValue(object $value, JsonPointer $path): JsonObject
    {
        $properties = [];

        /**
         * @var string $key
         * @var null|scalar|object|list<mixed> $property
         */
        foreach ($value as $key => $property) {
            $properties[$key] = $this->convertValue($property, $path->addToken($key));
        }

        return new JsonObject($properties, $path);
    }

    /**
     * @param list<mixed> $value
     * @param JsonPointer $path
     * @return JsonArray
     */
    private function convertArrayValue(array $value, JsonPointer $path): JsonArray
    {
        $items = [];

        /**
         * @var null|scalar|object|list<mixed> $item
         */
        foreach ($value as $index => $item) {
            $items[] = $this->convertValue($item, $path->addToken((string)$index));
        }

        return new JsonArray($items, $path);
    }
}
