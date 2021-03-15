<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Json;

final class JsonPointer
{
    /**
     * @var string[]
     */
    private $tokens;

    /**
     * @param string ...$tokens
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
        return new self(...$this->tokens, ...[$token]);
    }

    /**
     * @param self $pointer
     * @return self
     */
    public function addPointer(self $pointer): self
    {
        return new self(...$this->tokens, ...$pointer->tokens);
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
