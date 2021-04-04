<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Schema;

use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;

/**
 * @psalm-immutable
 */
final class ProcessedSchema
{
    /**
     * @var SchemaValidator
     */
    private $validator;

    /**
     * @var SchemaIdentifier
     */
    private $identifier;

    /**
     * @var list<SchemaReference>
     */
    private $anchors;

    /**
     * @var list<SchemaReference>
     */
    private $references;

    /**
     * @param SchemaValidator $validator
     * @param SchemaIdentifier $identifier
     * @param list<SchemaReference> $anchors
     * @param list<SchemaReference> $references
     */
    public function __construct(
        SchemaValidator $validator,
        SchemaIdentifier $identifier,
        array $anchors,
        array $references
    ) {
        $this->validator = $validator;
        $this->identifier = $identifier;
        $this->anchors = $anchors;
        $this->references = $references;
    }

    /**
     * @return SchemaValidator
     */
    public function getValidator(): SchemaValidator
    {
        return $this->validator;
    }

    /**
     * @return SchemaIdentifier
     */
    public function getIdentifier(): SchemaIdentifier
    {
        return $this->identifier;
    }

    /**
     * @return list<SchemaReference>
     */
    public function getAnchors(): array
    {
        return $this->anchors;
    }

    /**
     * @return list<SchemaReference>
     */
    public function getReferences(): array
    {
        return $this->references;
    }
}
