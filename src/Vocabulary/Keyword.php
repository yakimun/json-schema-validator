<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary;

use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;

interface Keyword
{
    /**
     * @param JsonValue $property
     * @param SchemaContext $context
     */
    public function process(JsonValue $property, SchemaContext $context): void;
}
