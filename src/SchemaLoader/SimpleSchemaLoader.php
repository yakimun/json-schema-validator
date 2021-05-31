<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\SchemaLoader;

use GuzzleHttp\Psr7\UriNormalizer;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonLoader\JsonLoader;

final class SimpleSchemaLoader implements SchemaLoader
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
    private $jsonLoader;

    /**
     * @param UriInterface $uri
     * @param JsonLoader $jsonLoader
     */
    public function __construct(UriInterface $uri, JsonLoader $jsonLoader)
    {
        $this->uri = $uri;
        $this->jsonLoader = $jsonLoader;
    }

    /**
     * @param UriInterface $uri
     * @return JsonValue|null
     */
    public function load(UriInterface $uri): ?JsonValue
    {
        return UriNormalizer::isEquivalent($this->uri, $uri) ? $this->jsonLoader->load() : null;
    }
}
