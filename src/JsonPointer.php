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
        return new self(...$this->tokens, ...$tokens);
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->tokens);
    }
}
