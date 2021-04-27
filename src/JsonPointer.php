<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator;

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
     * @param string ...$tokens
     * @return self
     * @no-named-arguments
     */
    public function addTokens(string ...$tokens): self
    {
        return new self(...array_merge($this->tokens, $tokens));
    }

    /**
     * @param self $pointer
     * @return bool
     */
    public function equals(self $pointer): bool
    {
        return $this->tokens === $pointer->tokens;
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
