<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\SchemaValidator;

/**
 * @psalm-immutable
 */
final class BooleanSchemaValidator implements SchemaValidator
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var bool
     */
    private $value;

    /**
     * @param string $absoluteLocation
     * @param bool $value
     */
    public function __construct(string $absoluteLocation, bool $value)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->value = $value;
    }
}
