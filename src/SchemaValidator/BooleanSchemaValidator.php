<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\SchemaValidator;

use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\JsonPointer;

/**
 * @psalm-immutable
 */
final class BooleanSchemaValidator implements SchemaValidator
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
     * @var bool
     */
    private bool $value;

    /**
     * @param UriInterface $uri
     * @param JsonPointer $fragment
     * @param bool $value
     */
    public function __construct(UriInterface $uri, JsonPointer $fragment, bool $value)
    {
        $this->uri = $uri;
        $this->fragment = $fragment;
        $this->value = $value;
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
     * @return bool
     */
    public function isValue(): bool
    {
        return $this->value;
    }
}
