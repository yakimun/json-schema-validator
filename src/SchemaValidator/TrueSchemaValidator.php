<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\SchemaValidator;

use Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier;

final class TrueSchemaValidator implements SchemaValidator
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
}
