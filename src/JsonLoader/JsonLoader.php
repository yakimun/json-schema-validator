<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\JsonLoader;

use Yakimun\JsonSchemaValidator\Json\JsonValue;

interface JsonLoader
{
    /**
     * @return JsonValue
     */
    public function load(): JsonValue;
}
