<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class DynamicRefKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var string
     */
    private $dynamicRef;

    /**
     * @param string $absoluteLocation
     * @param string $dynamicRef
     */
    public function __construct(string $absoluteLocation, string $dynamicRef)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->dynamicRef = $dynamicRef;
    }
}
