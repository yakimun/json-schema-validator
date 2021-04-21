<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Schema;

use Yakimun\JsonSchemaValidator\Json\JsonFalse;
use Yakimun\JsonSchemaValidator\SchemaValidator\FalseSchemaValidator;

/**
 * @psalm-immutable
 */
final class FalseSchema implements Schema
{
    /**
     * @var JsonFalse
     */
    private $value;

    /**
     * @var SchemaIdentifier
     */
    private $identifier;

    /**
     * @param JsonFalse $value
     * @param SchemaIdentifier $identifier
     */
    public function __construct(JsonFalse $value, SchemaIdentifier $identifier)
    {
        $this->value = $value;
        $this->identifier = $identifier;
    }

    /**
     * @return non-empty-list<ProcessedSchema>
     */
    public function process(): array
    {
        $validator = new FalseSchemaValidator($this->identifier);

        return [new ProcessedSchema($validator, $this->identifier, [], [], $this->value->getPath())];
    }
}
