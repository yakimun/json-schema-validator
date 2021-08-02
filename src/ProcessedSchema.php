<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator;

use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;

/**
 * @psalm-immutable
 */
final class ProcessedSchema
{
    /**
     * @var SchemaValidator
     */
    private SchemaValidator $validator;

    /**
     * @var non-empty-list<SchemaIdentifier>
     */
    private array $identifiers;

    /**
     * @var list<SchemaAnchor>
     */
    private array $anchors;

    /**
     * @var list<SchemaReference>
     */
    private array $references;

    /**
     * @param SchemaValidator $validator
     * @param non-empty-list<SchemaIdentifier> $identifiers
     * @param list<SchemaAnchor> $anchors
     * @param list<SchemaReference> $references
     */
    public function __construct(SchemaValidator $validator, array $identifiers, array $anchors, array $references)
    {
        $this->validator = $validator;
        $this->identifiers = $identifiers;
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
     * @return non-empty-list<SchemaIdentifier>
     */
    public function getIdentifiers(): array
    {
        return $this->identifiers;
    }

    /**
     * @return list<SchemaAnchor>
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
