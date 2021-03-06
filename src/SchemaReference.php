<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator;

use Psr\Http\Message\UriInterface;

/**
 * @psalm-immutable
 */
final class SchemaReference
{
    /**
     * @var UriInterface
     */
    private UriInterface $uri;

    /**
     * @var JsonPointer
     */
    private JsonPointer $path;

    /**
     * @param UriInterface $uri
     * @param JsonPointer $path
     */
    public function __construct(UriInterface $uri, JsonPointer $path)
    {
        $this->uri = $uri;
        $this->path = $path;
    }

    /**
     * @return UriInterface
     */
    public function getUri(): UriInterface
    {
        return $this->uri;
    }

    /**
     * @return JsonPointer
     */
    public function getPath(): JsonPointer
    {
        return $this->path;
    }
}
