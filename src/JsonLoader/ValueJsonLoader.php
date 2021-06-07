<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\JsonLoader;

use Yakimun\JsonSchemaValidator\Exception\InvalidValueException;
use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonBoolean;
use Yakimun\JsonSchemaValidator\Json\JsonFloat;
use Yakimun\JsonSchemaValidator\Json\JsonInteger;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;

/**
 * @psalm-immutable
 */
final class ValueJsonLoader implements JsonLoader
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        /** @var null|scalar|object|array<array-key, mixed> $value */
        $this->value = $value;
    }

    /**
     * @return JsonValue
     */
    public function load(): JsonValue
    {
        return $this->convert($this->value, new JsonPointer());
    }

    /**
     * @param mixed $value
     * @param JsonPointer $path
     * @return JsonValue
     */
    private function convert($value, JsonPointer $path): JsonValue
    {
        if (is_null($value)) {
            return new JsonNull();
        }

        if (is_bool($value)) {
            return new JsonBoolean($value);
        }

        if (is_object($value)) {
            return $this->convertObject($value, $path);
        }

        if (is_array($value)) {
            return $this->convertArray($value, $path);
        }

        if (is_int($value)) {
            return new JsonInteger($value);
        }

        if (is_float($value)) {
            return new JsonFloat($value);
        }

        if (is_string($value)) {
            return new JsonString($value);
        }

        $message = sprintf('Value must be null, boolean, object, array, int, float, or string at "%s"', (string)$path);
        throw new InvalidValueException($message);
    }

    /**
     * @param object $value
     * @param JsonPointer $path
     * @return JsonObject
     */
    private function convertObject(object $value, JsonPointer $path): JsonObject
    {
        $properties = [];

        /** @var null|scalar|object|array<array-key, mixed> $property */
        foreach (get_object_vars($value) as $key => $property) {
            $properties[$key] = $this->convert($property, $path->addTokens($key));
        }

        return new JsonObject($properties);
    }

    /**
     * @param array<array-key, mixed> $value
     * @param JsonPointer $path
     * @return JsonArray
     */
    private function convertArray(array $value, JsonPointer $path): JsonArray
    {
        $items = [];
        $expectedIndex = 0;

        /** @var null|scalar|object|array<array-key, mixed> $item */
        foreach ($value as $index => $item) {
            $stringIndex = (string)$index;

            if ($index !== $expectedIndex) {
                $format = 'Array keys must be integers starting from 0 with no gaps in between at "%s"';
                throw new InvalidValueException(sprintf($format, (string)$path->addTokens($stringIndex)));
            }

            $items[] = $this->convert($item, $path->addTokens($stringIndex));
            $expectedIndex++;
        }

        return new JsonArray($items);
    }
}
