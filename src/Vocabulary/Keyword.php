<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary;

use Yakimun\JsonSchemaValidator\SchemaContext;

interface Keyword
{
    /**
     * @param list<mixed>|null|object|scalar $property
     * @param SchemaContext $context
     */
    public function process($property, SchemaContext $context): void;
}
