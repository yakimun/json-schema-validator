<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\SchemaLoader;

use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\SchemaLoaderResult;

final class CachingSchemaLoader implements SchemaLoader
{
    /**
     * @var SchemaLoader
     * @readonly
     */
    private SchemaLoader $loader;

    /**
     * @var array<string, SchemaLoaderResult|null>
     */
    private array $results = [];

    /**
     * @param SchemaLoader $loader
     */
    public function __construct(SchemaLoader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * @param UriInterface $uri
     * @return SchemaLoaderResult|null
     */
    public function load(UriInterface $uri): ?SchemaLoaderResult
    {
        $uriString = (string)$uri;

        if (!array_key_exists($uriString, $this->results)) {
            $this->results[$uriString] = $this->loader->load($uri);
        }

        return $this->results[$uriString];
    }
}
