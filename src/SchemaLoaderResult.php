<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator;

/**
 * @psalm-immutable
 */
final class SchemaLoaderResult
{
    /**
     * @var scalar|object|list<mixed>|null
     */
    private $schema;

    /**
     * @param scalar|object|list<mixed>|null $schema
     */
    public function __construct($schema)
    {
        $this->schema = $schema;
    }

    /**
     * @return scalar|object|list<mixed>|null
     */
    public function getSchema()
    {
        return $this->schema;
    }
}
