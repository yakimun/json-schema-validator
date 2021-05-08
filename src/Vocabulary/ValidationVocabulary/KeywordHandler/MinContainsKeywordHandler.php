<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class MinContainsKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var int
     */
    private $minContains;

    /**
     * @param string $absoluteLocation
     * @param int $minContains
     */
    public function __construct(string $absoluteLocation, int $minContains)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->minContains = $minContains;
    }
}
