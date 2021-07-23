<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator;

use GuzzleHttp\Psr7\UriNormalizer;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Exception\SchemaException;
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
     * @var JsonPointer
     * @readonly
     */
    private JsonPointer $path;

    /**
     * @var non-empty-list<SchemaIdentifier>
     */
    private array $identifiers;

    /**
     * @var list<SchemaReference>
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
     * @param JsonPointer $path
     * @param non-empty-list<SchemaIdentifier> $identifiers
     */
    public function __construct(SchemaProcessor $processor, JsonPointer $path, array $identifiers)
    {
        $this->processor = $processor;
        $this->path = $path;
        $this->identifiers = $identifiers;
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
     * @return non-empty-list<SchemaIdentifier>
     * @psalm-mutation-free
     */
    public function getIdentifiers(): array
    {
        return $this->identifiers;
    }

    /**
     * @param UriInterface $identifier
     * @param string $token
     */
    public function addIdentifier(UriInterface $identifier, string $token): void
    {
        $schemaIdentifier = new SchemaIdentifier($identifier, new JsonPointer(), $this->path->addTokens($token));

        if (UriNormalizer::isEquivalent(end($this->identifiers)->getUri(), $identifier)) {
            $this->identifiers = [$schemaIdentifier];

            return;
        }

        $this->identifiers[] = $schemaIdentifier;
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
     * @param UriInterface $anchor
     * @param string $token
     */
    public function addAnchor(UriInterface $anchor, string $token): void
    {
        $this->anchors[] = new SchemaReference($anchor, $this->path->addTokens($token));
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
        $this->references[] = new SchemaReference($reference, $this->path->addTokens($token));
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
     * @param mixed $schema
     * @param string ...$tokens
     * @return SchemaValidator
     * @no-named-arguments
     */
    public function createValidator($schema, string ...$tokens): SchemaValidator
    {
        $identifiers = [];

        foreach ($this->identifiers as $identifier) {
            $identifierUri = $identifier->getUri();
            $identifierFragment = $identifier->getFragment()->addTokens(...$tokens);
            $identifierPath = $identifier->getPath()->addTokens(...$tokens);

            $identifiers[] = new SchemaIdentifier($identifierUri, $identifierFragment, $identifierPath);
        }

        $path = $this->path->addTokens(...$tokens);

        $processedSchemas = $this->processor->process($schema, $identifiers, $path);
        $this->processedSchemas = [...$this->processedSchemas, ...$processedSchemas];

        return $processedSchemas[0]->getValidator();
    }

    /**
     * @param string $message
     * @param string $token
     * @return SchemaException
     * @no-named-arguments
     * @psalm-mutation-free
     */
    public function createException(string $message, string $token): SchemaException
    {
        return new SchemaException(sprintf('%s Path: "%s".', $message, (string)$this->path->addTokens($token)));
    }
}
