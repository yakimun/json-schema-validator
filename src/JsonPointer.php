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
    private array $tokens;

    /**
     * @param list<string> $tokens
     */
    public function __construct(array $tokens)
    {
        $this->tokens = $tokens;
    }

    /**
     * @param list<string> $tokens
     * @return self
     */
    public function addTokens(array $tokens): self
    {
        return new self([...$this->tokens, ...$tokens]);
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return !$this->tokens;
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
