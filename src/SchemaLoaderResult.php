<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator;

/**
 * @psalm-immutable
 */
final class SchemaLoaderResult
{
    /**
     * @var mixed
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
     * @return mixed
     */
    public function getSchema()
    {
        return $this->schema;
    }
}
