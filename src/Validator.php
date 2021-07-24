<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator;

use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;

/**
 * @psalm-immutable
 */
final class Validator
{
    private SchemaValidator $schemaValidator;

    /**
     * @var array<string, SchemaValidator>
     */
    private array $schemaValidators;

    /**
     * @param array<string, SchemaValidator> $schemaValidators
     */
    public function __construct(SchemaValidator $schemaValidator, array $schemaValidators)
    {
        $this->schemaValidator = $schemaValidator;
        $this->schemaValidators = $schemaValidators;
    }
}
