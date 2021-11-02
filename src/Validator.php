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
     * @var list<string>
     */
    private array $dynamicUris;

    /**
     * @param SchemaValidator $schemaValidator
     * @param array<string, SchemaValidator> $schemaValidators
     * @param list<string> $dynamicUris
     */
    public function __construct(SchemaValidator $schemaValidator, array $schemaValidators, array $dynamicUris)
    {
        $this->schemaValidator = $schemaValidator;
        $this->schemaValidators = $schemaValidators;
        $this->dynamicUris = $dynamicUris;
    }

    /**
     * @return SchemaValidator
     */
    public function getSchemaValidator(): SchemaValidator
    {
        return $this->schemaValidator;
    }

    /**
     * @return array<string, SchemaValidator>
     */
    public function getSchemaValidators(): array
    {
        return $this->schemaValidators;
    }

    /**
     * @return list<string>
     */
    public function getDynamicUris(): array
    {
        return $this->dynamicUris;
    }
}
