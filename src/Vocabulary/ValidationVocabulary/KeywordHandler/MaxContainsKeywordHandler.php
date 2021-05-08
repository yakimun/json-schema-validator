<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class MaxContainsKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var int
     */
    private $maxContains;

    /**
     * @param string $absoluteLocation
     * @param int $maxContains
     */
    public function __construct(string $absoluteLocation, int $maxContains)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->maxContains = $maxContains;
    }
}
