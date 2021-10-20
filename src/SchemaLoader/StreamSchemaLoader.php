<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\SchemaLoader;

use GuzzleHttp\Psr7\UriNormalizer;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Exception\SchemaLoaderException;
use Yakimun\JsonSchemaValidator\SchemaLoaderResult;

final class StreamSchemaLoader implements SchemaLoader
{
    /**
     * @var UriInterface
     * @readonly
     */
    private UriInterface $uri;

    /**
     * @var StreamInterface
     * @readonly
     */
    private StreamInterface $stream;

    /**
     * @param UriInterface $uri
     * @param StreamInterface $stream
     */
    public function __construct(UriInterface $uri, StreamInterface $stream)
    {
        $this->uri = $uri;
        $this->stream = $stream;
    }

    /**
     * @param UriInterface $uri
     * @return SchemaLoaderResult|null
     */
    public function load(UriInterface $uri): ?SchemaLoaderResult
    {
        if (!UriNormalizer::isEquivalent($this->uri, $uri)) {
            return null;
        }

        try {
            $json = $this->stream->getContents();
        } catch (\RuntimeException $e) {
            $message = sprintf('The stream must be readable. Error: "%s".', $e->getMessage());
            throw new SchemaLoaderException($message, 0, $e);
        }

        try {
            /**
             * @var scalar|object|list<mixed>|null $schema
             */
            $schema = json_decode($json, false, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            $message = sprintf('The value must be a valid JSON document. Error: "%s".', $e->getMessage());
            throw new SchemaLoaderException($message, 0, $e);
        }

        return new SchemaLoaderResult($schema);
    }
}
