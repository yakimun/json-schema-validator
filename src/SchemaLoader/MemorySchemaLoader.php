<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\SchemaLoader;

use GuzzleHttp\Psr7\UriNormalizer;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\SchemaLoaderResult;

/**
 * @psalm-immutable
 */
final class MemorySchemaLoader implements SchemaLoader
{
    /**
     * @var UriInterface
     */
    private UriInterface $uri;

    /**
     * @var scalar|object|list<mixed>|null
     */
    private $schema;

    /**
     * @param UriInterface $uri
     * @param scalar|object|list<mixed>|null $schema
     */
    public function __construct(UriInterface $uri, $schema)
    {
        $this->uri = $uri;
        $this->schema = $schema;
    }

    /**
     * @param UriInterface $uri
     * @return SchemaLoaderResult|null
     */
    public function load(UriInterface $uri): ?SchemaLoaderResult
    {
        /**
         * @psalm-suppress ImpureMethodCall
         */
        return UriNormalizer::isEquivalent($this->uri, $uri) ? new SchemaLoaderResult($this->schema) : null;
    }
}
