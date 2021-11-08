<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\SchemaFinder;

use GuzzleHttp\Psr7\UriResolver;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\JsonLoader\FileJsonLoader;
use Yakimun\JsonSchemaValidator\JsonLoader\JsonLoader;

final class DirectorySchemaFinder implements SchemaFinder
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
     * @return JsonLoader|null
     */
    public function find(UriInterface $uri): ?JsonLoader
    {
        $directory = realpath($this->directory);
        $filename = realpath($directory . DIRECTORY_SEPARATOR . UriResolver::relativize($this->uri, $uri));

        if (
            !$directory
            || !$filename
            || !is_dir($directory)
            || !is_file($filename)
            || strpos($filename, $directory) !== 0
        ) {
            return null;
        }

        return new FileJsonLoader($filename);
    }
}
