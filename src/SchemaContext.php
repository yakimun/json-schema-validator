<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator;

use GuzzleHttp\Psr7\UriNormalizer;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Exception\SchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

final class SchemaContext
{
    /**
     * @var SchemaProcessor
     * @readonly
     */
    private SchemaProcessor $processor;

    /**
     * @var non-empty-array<string, JsonValue>
     * @readonly
     */
    private array $properties;

    /**
     * @var JsonPointer
     * @readonly
     */
    private JsonPointer $path;

    /**
     * @var SchemaIdentifier
     */
    private SchemaIdentifier $identifier;

    /**
     * @var list<SchemaIdentifier>
     */
    private array $nonCanonicalIdentifiers;

    /**
     * @var list<SchemaAnchor>
     */
    private array $anchors = [];

    /**
     * @var list<SchemaReference>
     */
    private array $references = [];

    /**
     * @var list<KeywordValidator>
     */
    private array $keywordValidators = [];

    /**
     * @var list<ProcessedSchema>
     */
    private array $processedSchemas = [];

    /**
     * @param SchemaProcessor $processor
     * @param non-empty-array<string, JsonValue> $properties
     * @param JsonPointer $path
     * @param SchemaIdentifier $identifier
     * @param list<SchemaIdentifier> $nonCanonicalIdentifiers
     */
    public function __construct(
        SchemaProcessor $processor,
        array $properties,
        JsonPointer $path,
        SchemaIdentifier $identifier,
        array $nonCanonicalIdentifiers
    ) {
        $this->processor = $processor;
        $this->properties = $properties;
        $this->path = $path;
        $this->identifier = $identifier;
        $this->nonCanonicalIdentifiers = $nonCanonicalIdentifiers;
    }

    /**
     * @return non-empty-array<string, JsonValue>
     * @psalm-mutation-free
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @return JsonPointer
     * @psalm-mutation-free
     */
    public function getPath(): JsonPointer
    {
        return $this->path;
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
     * @param UriInterface $identifier
     * @param string $token
     */
    public function setIdentifier(UriInterface $identifier, string $token): void
    {
        $schemaIdentifier = new SchemaIdentifier($identifier, new JsonPointer([]), $this->path->addTokens([$token]));

        if (UriNormalizer::isEquivalent($this->identifier->getUri(), $identifier)) {
            $this->identifier = $schemaIdentifier;

            return;
        }

        $this->nonCanonicalIdentifiers[] = $this->identifier;
        $this->identifier = $schemaIdentifier;
    }

    /**
     * @return list<SchemaIdentifier>
     * @psalm-mutation-free
     */
    public function getNonCanonicalIdentifiers(): array
    {
        return $this->nonCanonicalIdentifiers;
    }

    /**
     * @return list<SchemaAnchor>
     * @psalm-mutation-free
     */
    public function getAnchors(): array
    {
        return $this->anchors;
    }

    /**
     * @param UriInterface $anchor
     * @param bool $dynamic
     * @param string $token
     */
    public function addAnchor(UriInterface $anchor, bool $dynamic, string $token): void
    {
        $this->anchors[] = new SchemaAnchor($anchor, $dynamic, $this->path->addTokens([$token]));
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
     * @param UriInterface $reference
     * @param string $token
     */
    public function addReference(UriInterface $reference, string $token): void
    {
        $this->references[] = new SchemaReference($reference, $this->path->addTokens([$token]));
    }

    /**
     * @return list<KeywordValidator>
     * @psalm-mutation-free
     */
    public function getKeywordValidators(): array
    {
        return $this->keywordValidators;
    }

    /**
     * @param KeywordValidator $keywordValidator
     */
    public function addKeywordValidator(KeywordValidator $keywordValidator): void
    {
        $this->keywordValidators[] = $keywordValidator;
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
     * @param JsonValue $schema
     * @param list<string> $tokens
     * @return SchemaValidator
     */
    public function createValidator(JsonValue $schema, array $tokens): SchemaValidator
    {
        $identifier = $this->advanceIdentifier($this->identifier, $tokens);

        $nonCanonicalIdentifiers = [];

        foreach ($this->nonCanonicalIdentifiers as $nonCanonicalIdentifier) {
            $nonCanonicalIdentifiers[] = $this->advanceIdentifier($nonCanonicalIdentifier, $tokens);
        }

        $path = $this->path->addTokens($tokens);

        $processedSchemas = $this->processor->process($schema, $identifier, $nonCanonicalIdentifiers, $path);
        $this->processedSchemas = [...$this->processedSchemas, ...$processedSchemas];

        return $processedSchemas[0]->getValidator();
    }

    /**
     * @param SchemaIdentifier $identifier
     * @param list<string> $tokens
     * @return SchemaIdentifier
     * @psalm-mutation-free
     */
    private function advanceIdentifier(SchemaIdentifier $identifier, array $tokens): SchemaIdentifier
    {
        $identifierUri = $identifier->getUri();
        $identifierFragment = $identifier->getFragment()->addTokens($tokens);
        $identifierPath = $identifier->getPath()->addTokens($tokens);

        return new SchemaIdentifier($identifierUri, $identifierFragment, $identifierPath);
    }

    /**
     * @param string $message
     * @param string $token
     * @return SchemaException
     * @psalm-mutation-free
     */
    public function createException(string $message, string $token): SchemaException
    {
        return new SchemaException(sprintf('%s Path: "%s".', $message, (string)$this->path->addTokens([$token])));
    }
}
