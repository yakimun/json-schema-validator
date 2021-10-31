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
     * @var list<mixed>|null|object|scalar
     */
    private $value;

    /**
     * @param string $name
     * @param list<mixed>|null|object|scalar $value
     */
    public function __construct(string $name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }
}
