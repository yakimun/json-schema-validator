<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\JsonLoader;

use Yakimun\JsonSchemaValidator\Exception\JsonLoaderException;
use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonBoolean;
use Yakimun\JsonSchemaValidator\Json\JsonFloat;
use Yakimun\JsonSchemaValidator\Json\JsonInteger;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;

final class MixedJsonLoader implements JsonLoader
{
    /**
     * @var mixed
     * @readonly
     */
    private $value;

    /**
     * @param list<mixed>|null|object|scalar $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return JsonValue
     */
    public function load(): JsonValue
    {
        return $this->loadValue($this->value, new JsonPointer([]));
    }

    /**
     * @param mixed $value
     * @param JsonPointer $path
     * @return JsonValue
     * @psalm-mutation-free
     */
    private function loadValue($value, JsonPointer $path): JsonValue
    {
        if (is_null($value)) {
            return new JsonNull();
        }

        if (is_bool($value)) {
            return new JsonBoolean($value);
        }

        if (is_object($value)) {
            $properties = [];

            /**
             * @var list<mixed>|null|object|scalar $property
             */
            foreach (get_object_vars($value) as $key => $property) {
                $properties[$key] = $this->loadValue($property, $path->addTokens([$key]));
            }

            return new JsonObject($properties);
        }

        if (is_array($value)) {
            $elements = [];

            /**
             * @var list<mixed>|null|object|scalar $element
             */
            foreach ($value as $index => $element) {
                $elements[] = $this->loadValue($element, $path->addTokens([(string)$index]));
            }

            return new JsonArray($elements);
        }

        if (is_int($value)) {
            return new JsonInteger($value);
        }

        if (is_float($value)) {
            if (fmod($value, 1) === 0.0) {
                return new JsonInteger((int)$value);
            }

            return new JsonFloat($value);
        }

        if (is_string($value)) {
            return new JsonString($value);
        }

        $format = 'The value must be null, boolean, object, array, int, float, or string. Path: "%s".';
        throw new JsonLoaderException(sprintf($format, (string)$path));
    }
}
