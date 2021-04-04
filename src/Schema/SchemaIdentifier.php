<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Schema;

use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Json\JsonPointer;

/**
 * @psalm-immutable
 */
final class SchemaIdentifier
{
    /**
     * @var UriInterface
     */
    private $uri;

    /**
     * @var JsonPointer
     */
    private $fragment;

    /**
     * @param UriInterface $uri
     * @param JsonPointer $fragment
     */
    public function __construct(UriInterface $uri, JsonPointer $fragment)
    {
        $this->uri = $uri;
        $this->fragment = $fragment;
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
}
