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
    private $uri;

    /**
     * @var string
     * @readonly
     */
    private $directory;

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
        $filename = realpath($this->directory . UriResolver::relativize($this->uri, $uri));

        return $directory && $filename && strpos($filename, $directory) === 0 ? new FileJsonLoader($filename) : null;
    }
}
