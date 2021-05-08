<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class UniqueItemsKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var bool
     */
    private $uniqueItems;

    /**
     * @param string $absoluteLocation
     * @param bool $uniqueItems
     */
    public function __construct(string $absoluteLocation, bool $uniqueItems)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->uniqueItems = $uniqueItems;
    }
}
