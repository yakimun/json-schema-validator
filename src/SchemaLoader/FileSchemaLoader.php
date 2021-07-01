<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\SchemaLoader;

use GuzzleHttp\Psr7\UriNormalizer;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Exception\SchemaLoaderException;
use Yakimun\JsonSchemaValidator\SchemaLoaderResult;

final class FileSchemaLoader implements SchemaLoader
{
    /**
     * @var UriInterface
     * @readonly
     */
    private UriInterface $uri;

    /**
     * @var string
     * @readonly
     */
    private string $filename;

    /**
     * @param UriInterface $uri
     * @param string $filename
     */
    public function __construct(UriInterface $uri, string $filename)
    {
        $this->uri = $uri;
        $this->filename = $filename;
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

        $filename = realpath($this->filename);

        if (!$filename || !is_file($filename) || ($json = file_get_contents($filename)) === false) {
            throw new SchemaLoaderException('The file must exist and be readable.');
        }

        try {
            /** @var scalar|object|list<mixed>|null $schema */
            $schema = json_decode($json, false, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new SchemaLoaderException('The value must be a valid JSON document.', 0, $e);
        }

        return new SchemaLoaderResult($schema);
    }
}
