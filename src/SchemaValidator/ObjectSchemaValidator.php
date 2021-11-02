<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\SchemaValidator;

use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class ObjectSchemaValidator implements SchemaValidator
{
    /**
     * @var UriInterface
     */
    private UriInterface $uri;

    /**
     * @var JsonPointer
     */
    private JsonPointer $fragment;

    /**
     * @var list<KeywordValidator>
     */
    private array $keywordValidators;

    /**
     * @param UriInterface $uri
     * @param JsonPointer $fragment
     * @param list<KeywordValidator> $keywordValidators
     */
    public function __construct(UriInterface $uri, JsonPointer $fragment, array $keywordValidators)
    {
        $this->uri = $uri;
        $this->fragment = $fragment;
        $this->keywordValidators = $keywordValidators;
    }

    /**
     * @return UriInterface
     */
    public function getUri(): UriInterface
    {
        return $this->uri;
    }

    /**
     * @return JsonPointer
     */
    public function getFragment(): JsonPointer
    {
        return $this->fragment;
    }

    /**
     * @return list<KeywordValidator>
     */
    public function getKeywordValidators(): array
    {
        return $this->keywordValidators;
    }
}
