<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Schema;

use Yakimun\JsonSchemaValidator\Json\JsonPointer;
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
     * @var JsonPointer
     */
    private $path;

    /**
     * @param SchemaValidator $validator
     * @param SchemaIdentifier $identifier
     * @param list<SchemaReference> $anchors
     * @param list<SchemaReference> $references
     * @param JsonPointer $path
     */
    public function __construct(
        SchemaValidator $validator,
        SchemaIdentifier $identifier,
        array $anchors,
        array $references,
        JsonPointer $path
    ) {
        $this->validator = $validator;
        $this->identifier = $identifier;
        $this->anchors = $anchors;
        $this->references = $references;
        $this->path = $path;
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

    /**
     * @return JsonPointer
     */
    public function getPath(): JsonPointer
    {
        return $this->path;
    }
}
