<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class DynamicAnchorKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var string
     */
    private $dynamicAnchor;

    /**
     * @param string $absoluteLocation
     * @param string $dynamicAnchor
     */
    public function __construct(string $absoluteLocation, string $dynamicAnchor)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->dynamicAnchor = $dynamicAnchor;
    }
}
