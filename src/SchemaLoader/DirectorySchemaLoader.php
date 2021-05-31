<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\SchemaLoader;

use GuzzleHttp\Psr7\UriResolver;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonLoader\FileJsonLoader;

final class DirectorySchemaLoader implements SchemaLoader
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
     * @return JsonValue|null
     */
    public function load(UriInterface $uri): ?JsonValue
    {
        $directory = realpath($this->directory);
        $filename = realpath($this->directory . UriResolver::relativize($this->uri, $uri));

        if (!$directory || !$filename || strpos($filename, $directory) !== 0) {
            return null;
        }

        $loader = new FileJsonLoader($filename);

        return $loader->load();
    }
}
