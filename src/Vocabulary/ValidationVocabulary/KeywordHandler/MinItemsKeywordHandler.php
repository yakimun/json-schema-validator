<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class MinItemsKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var int
     */
    private $minItems;

    /**
     * @param string $absoluteLocation
     * @param int $minItems
     */
    public function __construct(string $absoluteLocation, int $minItems)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->minItems = $minItems;
    }
}
