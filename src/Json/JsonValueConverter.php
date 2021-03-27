<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Json;

use Yakimun\JsonSchemaValidator\Exception\InvalidValueException;

/**
 * @psalm-immutable
 */
final class JsonValueConverter
{
    /**
     * @param mixed $value
     * @return JsonValue
     */
    public function convert($value): JsonValue
    {
        return $this->convertValue($value, new JsonPointer());
    }

    /**
     * @param mixed $value
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

        if (is_string($value)) {
            return new JsonString($value, $path);
        }

        $format = 'The value must be a null, a boolean, an object, an array, an int, a float, or a string. Path: "%s".';
        throw new InvalidValueException(sprintf($format, (string)$path));
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
         * @var null|scalar|object|array<array-key, mixed> $property
         */
        foreach ($value as $key => $property) {
            $properties[$key] = $this->convertValue($property, $path->addToken($key));
        }

        return new JsonObject($properties, $path);
    }

    /**
     * @param array<array-key, mixed> $value
     * @param JsonPointer $path
     * @return JsonArray
     */
    private function convertArrayValue(array $value, JsonPointer $path): JsonArray
    {
        $items = [];
        $expectedIndex = 0;

        /**
         * @var null|scalar|object|array<array-key, mixed> $item
         */
        foreach ($value as $index => $item) {
            if ($index !== $expectedIndex) {
                $format = 'The array keys must be integers starting from 0 with no gaps in between. Path: "%s".';
                throw new InvalidValueException(sprintf($format, (string)$path));
            }

            $items[] = $this->convertValue($item, $path->addToken((string)$index));
            $expectedIndex++;
        }

        return new JsonArray($items, $path);
    }
}
