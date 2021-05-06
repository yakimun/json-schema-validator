<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary;

use Yakimun\JsonSchemaValidator\Json\JsonValue;

/**
 * @psalm-immutable
 */
final class UnknownKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var string
     */
    private $name;

    /**
     * @var JsonValue
     */
    private $value;

    /**
     * @param string $absoluteLocation
     * @param string $name
     * @param JsonValue $value
     */
    public function __construct(string $absoluteLocation, string $name, JsonValue $value)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->name = $name;
        $this->value = $value;
    }
}
