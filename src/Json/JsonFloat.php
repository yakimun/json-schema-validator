<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Json;

/**
 * @psalm-immutable
 */
final class JsonFloat implements JsonValue
{
    /**
     * @var float
     */
    private $value;

    /**
     * @var JsonPointer
     */
    private $path;

    /**
     * @param float $value
     * @param JsonPointer $path
     */
    public function __construct(float $value, JsonPointer $path)
    {
        $this->value = $value;
        $this->path = $path;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
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
        return $value instanceof self && $this->value === $value->value;
    }
}
