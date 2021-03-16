<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Json;

final class JsonNull implements JsonValue
{
    /**
     * @var JsonPointer
     */
    private $path;

    /**
     * @param JsonPointer $path
     */
    public function __construct(JsonPointer $path)
    {
        $this->path = $path;
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
        return $value instanceof self;
    }
}
