<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator;

use Psr\Http\Message\UriInterface;

/**
 * @psalm-immutable
 */
final class SchemaIdentifier
{
    /**
     * @var UriInterface
     */
    private UriInterface $uri;

    /**
     * @var JsonPointer
     */
    private JsonPointer $fragment;

    /**
     * @var JsonPointer
     */
    private JsonPointer $path;

    /**
     * @param UriInterface $uri
     * @param JsonPointer $fragment
     * @param JsonPointer $path
     */
    public function __construct(UriInterface $uri, JsonPointer $fragment, JsonPointer $path)
    {
        $this->uri = $uri;
        $this->fragment = $fragment;
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
    public function getFragment(): JsonPointer
    {
        return $this->fragment;
    }

    /**
     * @return JsonPointer
     */
    public function getPath(): JsonPointer
    {
        return $this->path;
    }
}
