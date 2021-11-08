<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\JsonLoader;

use Yakimun\JsonSchemaValidator\Json\JsonValue;

final class MemoryJsonLoader implements JsonLoader
{
    /**
     * @var JsonValue
     * @readonly
     */
    private JsonValue $value;

    /**
     * @param JsonValue $value
     */
    public function __construct(JsonValue $value)
    {
        $this->value = $value;
    }

    /**
     * @return JsonValue
     */
    public function load(): JsonValue
    {
        return $this->value;
    }
}
