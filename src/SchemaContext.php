<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator;

use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

final class SchemaContext
{
    /**
     * @var non-empty-array<string, Keyword>
     * @readonly
     */
    private $keywords;

    /**
     * @var SchemaIdentifier
     */
    private $identifier;

    /**
     * @var list<SchemaReference>
     */
    private $anchors = [];

    /**
     * @var list<SchemaReference>
     */
    private $references = [];

    /**
     * @var list<KeywordHandler>
     */
    private $keywordHandlers = [];

    /**
     * @var list<ProcessedSchema>
     */
    private $processedSchemas = [];

    /**
     * @param non-empty-array<string, Keyword> $keywords
     * @param SchemaIdentifier $identifier
     */
    public function __construct(array $keywords, SchemaIdentifier $identifier)
    {
        $this->keywords = $keywords;
        $this->identifier = $identifier;
    }

    /**
     * @return SchemaIdentifier
     * @psalm-mutation-free
     */
    public function getIdentifier(): SchemaIdentifier
    {
        return $this->identifier;
    }

    /**
     * @param SchemaIdentifier $identifier
     */
    public function setIdentifier(SchemaIdentifier $identifier): void
    {
        $this->identifier = $identifier;
    }

    /**
     * @return list<SchemaReference>
     * @psalm-mutation-free
     */
    public function getAnchors(): array
    {
        return $this->anchors;
    }

    /**
     * @param SchemaReference $anchor
     */
    public function addAnchor(SchemaReference $anchor): void
    {
        $this->anchors[] = $anchor;
    }

    /**
     * @return list<SchemaReference>
     * @psalm-mutation-free
     */
    public function getReferences(): array
    {
        return $this->references;
    }

    /**
     * @param SchemaReference $ref
     */
    public function addReference(SchemaReference $ref): void
    {
        $this->references[] = $ref;
    }

    /**
     * @return list<KeywordHandler>
     * @psalm-mutation-free
     */
    public function getKeywordHandlers(): array
    {
        return $this->keywordHandlers;
    }

    /**
     * @param KeywordHandler $keywordHandler
     */
    public function addKeywordHandler(KeywordHandler $keywordHandler): void
    {
        $this->keywordHandlers[] = $keywordHandler;
    }

    /**
     * @return list<ProcessedSchema>
     * @psalm-mutation-free
     */
    public function getProcessedSchemas(): array
    {
        return $this->processedSchemas;
    }

    /**
     * @param JsonValue $value
     * @param SchemaIdentifier $identifier
     * @return SchemaValidator
     */
    public function createValidator(JsonValue $value, SchemaIdentifier $identifier): SchemaValidator
    {
        $processedSchemas = $value->processAsSchema($identifier, $this->keywords);
        $this->processedSchemas = array_merge($this->processedSchemas, $processedSchemas);

        return $processedSchemas[0]->getValidator();
    }
}
