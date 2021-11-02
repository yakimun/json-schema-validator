<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator;

use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class DynamicRefKeywordValidator implements KeywordValidator
{
    /**
     * @var UriInterface
     */
    private UriInterface $dynamicRef;

    /**
     * @param UriInterface $dynamicRef
     */
    public function __construct(UriInterface $dynamicRef)
    {
        $this->dynamicRef = $dynamicRef;
    }

    /**
     * @return UriInterface
     */
    public function getDynamicRef(): UriInterface
    {
        return $this->dynamicRef;
    }
}
