<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\SchemaLoader;

use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Json\JsonValue;

interface SchemaLoader
{
    /**
     * @param UriInterface $uri
     * @return JsonValue|null
     */
    public function load(UriInterface $uri): ?JsonValue;
}
