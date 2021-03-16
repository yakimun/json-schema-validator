<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Json;

final class JsonInteger implements JsonValue
{
    /**
     * @var int
     */
    private $value;

    /**
     * @var JsonPointer
     */
    private $path;

    /**
     * @param int $value
     * @param JsonPointer $path
     */
    public function __construct(int $value, JsonPointer $path)
    {
        $this->value = $value;
        $this->path = $path;
    }

    /**
     * @return int
     */
    public function getValue(): int
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
