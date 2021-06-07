<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\SchemaFinder;

use GuzzleHttp\Psr7\UriNormalizer;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\JsonLoader\JsonLoader;

final class NoOpSchemaFinder implements SchemaFinder
{
    /**
     * @var UriInterface
     * @readonly
     */
    private $uri;

    /**
     * @var JsonLoader
     * @readonly
     */
    private $loader;

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
        return UriNormalizer::isEquivalent($this->uri, $uri) ? $this->loader : null;
    }
}
