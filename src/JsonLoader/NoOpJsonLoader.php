<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\JsonLoader;

use Yakimun\JsonSchemaValidator\Json\JsonValue;

/**
 * @psalm-immutable
 */
final class NoOpJsonLoader implements JsonLoader
{
    /**
     * @var JsonValue
     */
    private $value;

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
