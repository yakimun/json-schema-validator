<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator;

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
     * @var SchemaIdentifier
     */
    private SchemaIdentifier $identifier;

    /**
     * @var JsonPointer
     * @readonly
     */
    private JsonPointer $path;

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
     * @param SchemaIdentifier $identifier
     * @param JsonPointer $path
     */
    public function __construct(SchemaProcessor $processor, SchemaIdentifier $identifier, JsonPointer $path)
    {
        $this->processor = $processor;
        $this->identifier = $identifier;
        $this->path = $path;
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
        $this->identifier = new SchemaIdentifier($identifier, new JsonPointer(), $this->path->addTokens($token));
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
        $uri = $this->identifier->getUri();
        $fragment = $this->identifier->getFragment()->addTokens(...$tokens);
        $path = $this->path->addTokens(...$tokens);

        $processedSchemas = $this->processor->process($schema, $uri, $fragment, $path);
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
