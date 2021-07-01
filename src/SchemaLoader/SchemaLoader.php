<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\SchemaLoader;

use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\SchemaLoaderResult;

interface SchemaLoader
{
    /**
     * @param UriInterface $uri
     * @return SchemaLoaderResult|null
     */
    public function load(UriInterface $uri): ?SchemaLoaderResult;
}
