<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class MaxItemsKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var int
     */
    private $maxItems;

    /**
     * @param string $absoluteLocation
     * @param int $maxItems
     */
    public function __construct(string $absoluteLocation, int $maxItems)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->maxItems = $maxItems;
    }
}
