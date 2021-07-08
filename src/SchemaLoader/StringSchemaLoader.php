<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\SchemaLoader;

use GuzzleHttp\Psr7\UriNormalizer;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Exception\SchemaLoaderException;
use Yakimun\JsonSchemaValidator\SchemaLoaderResult;

/**
 * @psalm-immutable
 */
final class StringSchemaLoader implements SchemaLoader
{
    /**
     * @var UriInterface
     */
    private UriInterface $uri;

    /**
     * @var string
     */
    private string $json;

    /**
     * @param UriInterface $uri
     * @param string $json
     */
    public function __construct(UriInterface $uri, string $json)
    {
        $this->uri = $uri;
        $this->json = $json;
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
        if (!UriNormalizer::isEquivalent($this->uri, $uri)) {
            return null;
        }

        try {
            /** @var scalar|object|list<mixed>|null $schema */
            $schema = json_decode($this->json, false, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            $message = sprintf('The value must be a valid JSON document. Error: "%s".', $e->getMessage());
            throw new SchemaLoaderException($message, 0, $e);
        }

        return new SchemaLoaderResult($schema);
    }
}
