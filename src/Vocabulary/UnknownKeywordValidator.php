<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary;

use Yakimun\JsonSchemaValidator\Json\JsonValue;

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
     * @var JsonValue
     */
    private JsonValue $value;

    /**
     * @param string $name
     * @param JsonValue $value
     */
    public function __construct(string $name, JsonValue $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return JsonValue
     */
    public function getValue(): JsonValue
    {
        return $this->value;
    }
}
