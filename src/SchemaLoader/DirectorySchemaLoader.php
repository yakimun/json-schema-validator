<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\SchemaLoader;

use GuzzleHttp\Psr7\UriResolver;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Exception\SchemaLoaderException;
use Yakimun\JsonSchemaValidator\SchemaLoaderResult;

final class DirectorySchemaLoader implements SchemaLoader
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
    private string $directory;

    /**
     * @param UriInterface $uri
     * @param string $directory
     */
    public function __construct(UriInterface $uri, string $directory)
    {
        $this->uri = $uri;
        $this->directory = $directory;
    }

    /**
     * @param UriInterface $uri
     * @return SchemaLoaderResult|null
     */
    public function load(UriInterface $uri): ?SchemaLoaderResult
    {
        $directory = realpath($this->directory);
        $filename = realpath($directory . DIRECTORY_SEPARATOR . UriResolver::relativize($this->uri, $uri));

        if (
            !$directory
            || !$filename
            || !is_dir($directory)
            || !is_file($filename)
            || strpos($filename, $directory) !== 0
            || ($json = file_get_contents($filename)) === false
        ) {
            return null;
        }

        try {
            /**
             * @var list<mixed>|null|object|scalar $schema
             */
            $schema = json_decode($json, false, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            $message = sprintf('The value must be a valid JSON document. Error: "%s".', $e->getMessage());
            throw new SchemaLoaderException($message, 0, $e);
        }

        return new SchemaLoaderResult($schema);
    }
}
