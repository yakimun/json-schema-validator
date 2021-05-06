<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator;

use Psr\Http\Message\UriInterface;

final class SchemaIdentifier
{
    /**
     * @var UriInterface
     * @readonly
     */
    private $uri;

    /**
     * @var JsonPointer
     * @readonly
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
     * @psalm-mutation-free
     */
    public function getUri(): UriInterface
    {
        return $this->uri;
    }

    /**
     * @return JsonPointer
     * @psalm-mutation-free
     */
    public function getFragment(): JsonPointer
    {
        return $this->fragment;
    }

    /**
     * @param string ...$tokens
     * @return self
     * @no-named-arguments
     * @psalm-mutation-free
     */
    public function addTokens(string ...$tokens): self
    {
        return new self($this->uri, $this->fragment->addTokens(...$tokens));
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->uri->withFragment((string)$this->fragment);
    }
}
