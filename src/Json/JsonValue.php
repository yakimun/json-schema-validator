<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Json;

/**
 * @psalm-immutable
 */
interface JsonValue
{
    public function equals(JsonValue $value): bool;
}
