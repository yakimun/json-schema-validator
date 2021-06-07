<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\SchemaFinder;

use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\JsonLoader\JsonLoader;

interface SchemaFinder
{
    /**
     * @param UriInterface $uri
     * @return JsonLoader|null
     */
    public function find(UriInterface $uri): ?JsonLoader;
}
