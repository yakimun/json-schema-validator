<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\SchemaFinder;

use GuzzleHttp\Psr7\UriNormalizer;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\JsonLoader\JsonLoader;

final class LoaderSchemaFinder implements SchemaFinder
{
    /**
     * @var UriInterface
     * @readonly
     */
    private UriInterface $uri;

    /**
     * @var JsonLoader
     * @readonly
     */
    private JsonLoader $loader;

    /**
     * @param UriInterface $uri
     * @param JsonLoader $loader
     */
    public function __construct(UriInterface $uri, JsonLoader $loader)
    {
        $this->uri = $uri;
        $this->loader = $loader;
    }

    /**
     * @param UriInterface $uri
     * @return JsonLoader|null
     */
    public function find(UriInterface $uri): ?JsonLoader
    {
        if (!UriNormalizer::isEquivalent($this->uri, $uri)) {
            return null;
        }

        return $this->loader;
    }
}
