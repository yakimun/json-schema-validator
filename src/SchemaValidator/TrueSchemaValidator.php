<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\SchemaValidator;

/**
 * @psalm-immutable
 */
final class TrueSchemaValidator implements SchemaValidator
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @param string $absoluteLocation
     */
    public function __construct(string $absoluteLocation)
    {
        $this->absoluteLocation = $absoluteLocation;
    }
}
