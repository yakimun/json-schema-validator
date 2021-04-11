<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Json;

/**
 * @psalm-immutable
 */
final class JsonPointer
{
    /**
     * @var list<string>
     */
    private $tokens;

    /**
     * @param string ...$tokens
     * @no-named-arguments
     */
    public function __construct(string ...$tokens)
    {
        $this->tokens = $tokens;
    }

    /**
     * @param string $token
     * @return self
     */
    public function addToken(string $token): self
    {
        return new self(...array_merge($this->tokens, [$token]));
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $string = '';

        foreach ($this->tokens as $token) {
            $string .= '/' . str_replace(['~', '/'], ['~0', '~1'], $token);
        }

        return $string;
    }
}
