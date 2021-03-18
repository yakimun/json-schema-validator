<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Json;

/**
 * @psalm-immutable
 */
interface JsonValue
{
    /**
     * @return JsonPointer
     */
    public function getPath(): JsonPointer;

    /**
     * @param JsonValue $value
     * @return bool
     */
    public function equals(JsonValue $value): bool;
}
