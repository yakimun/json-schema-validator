<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Schema;

use Yakimun\JsonSchemaValidator\Json\JsonTrue;
use Yakimun\JsonSchemaValidator\SchemaValidator\TrueSchemaValidator;

/**
 * @psalm-immutable
 */
final class TrueSchema implements Schema
{
    /**
     * @var JsonTrue
     */
    private $value;

    /**
     * @var SchemaIdentifier
     */
    private $identifier;

    /**
     * @param JsonTrue $value
     * @param SchemaIdentifier $identifier
     */
    public function __construct(JsonTrue $value, SchemaIdentifier $identifier)
    {
        $this->value = $value;
        $this->identifier = $identifier;
    }

    /**
     * @return non-empty-list<ProcessedSchema>
     */
    public function process(): array
    {
        $validator = new TrueSchemaValidator($this->identifier);

        return [new ProcessedSchema($validator, $this->identifier, [], [], $this->value->getPath())];
    }
}
