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
    private $tokens = [];

    /**
     * @param string $token
     * @return self
     */
    public function addToken(string $token): self
    {
        $pointer = new self();
        $pointer->tokens = $this->tokens;
        $pointer->tokens[] = $token;

        return $pointer;
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
