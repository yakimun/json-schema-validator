<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator;

/**
 * @psalm-immutable
 */
final class SchemaLoaderResult
{
    /**
     * @var list<mixed>|null|object|scalar
     */
    private $schema;

    /**
     * @param list<mixed>|null|object|scalar $schema
     */
    public function __construct($schema)
    {
        $this->schema = $schema;
    }

    /**
     * @return list<mixed>|null|object|scalar
     */
    public function getSchema()
    {
        return $this->schema;
    }
}
