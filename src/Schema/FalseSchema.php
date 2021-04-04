<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Schema;

use Yakimun\JsonSchemaValidator\SchemaValidator\FalseSchemaValidator;

/**
 * @psalm-immutable
 */
final class FalseSchema implements Schema
{
    /**
     * @var SchemaIdentifier
     */
    private $identifier;

    /**
     * @param SchemaIdentifier $identifier
     */
    public function __construct(SchemaIdentifier $identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @return non-empty-list<ProcessedSchema>
     */
    public function process(): array
    {
        return [new ProcessedSchema(new FalseSchemaValidator($this->identifier), $this->identifier, [], [])];
    }
}
