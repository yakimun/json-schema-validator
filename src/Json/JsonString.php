<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Json;

final class JsonString implements JsonValue
{
    /**
     * @var string
     */
    private $value;

    /**
     * @var JsonPointer
     */
    private $path;

    /**
     * @param string $value
     * @param JsonPointer $path
     */
    public function __construct(string $value, JsonPointer $path)
    {
        $this->value = $value;
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getValue(): string
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
