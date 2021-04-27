<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordHandler;

use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class DynamicRefKeywordHandler implements KeywordHandler
{
    /**
     * @var UriInterface
     */
    private $dynamicRef;

    /**
     * @param UriInterface $dynamicRef
     */
    public function __construct(UriInterface $dynamicRef)
    {
        $this->dynamicRef = $dynamicRef;
    }
}
