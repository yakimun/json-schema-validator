<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Schema;

interface Schema
{
    /**
     * @return non-empty-list<ProcessedSchema>
     */
    public function process(): array;
}
