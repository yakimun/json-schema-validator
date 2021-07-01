<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary;

/**
 * @psalm-immutable
 */
final class UnknownKeywordValidator implements KeywordValidator
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @param string $name
     * @param scalar|object|list<mixed>|null $value
     */
    public function __construct(string $name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }
}
