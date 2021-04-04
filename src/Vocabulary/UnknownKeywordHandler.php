<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary;

use Yakimun\JsonSchemaValidator\Json\JsonValue;

final class UnknownKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var JsonValue
     */
    private $value;

    /**
     * @param string $name
     * @param JsonValue $value
     */
    public function __construct(string $name, JsonValue $value)
    {
        $this->name = $name;
        $this->value = $value;
    }
}
