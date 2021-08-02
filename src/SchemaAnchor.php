<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator;

use Psr\Http\Message\UriInterface;

/**
 * @psalm-immutable
 */
final class SchemaAnchor
{
    /**
     * @var UriInterface
     */
    private UriInterface $uri;

    /**
     * @var bool
     */
    private bool $dynamic;

    /**
     * @var JsonPointer
     */
    private JsonPointer $path;

    /**
     * @param UriInterface $uri
     * @param bool $dynamic
     * @param JsonPointer $path
     */
    public function __construct(UriInterface $uri, bool $dynamic, JsonPointer $path)
    {
        $this->uri = $uri;
        $this->dynamic = $dynamic;
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
     * @return bool
     */
    public function isDynamic(): bool
    {
        return $this->dynamic;
    }

    /**
     * @return JsonPointer
     */
    public function getPath(): JsonPointer
    {
        return $this->path;
    }
}
