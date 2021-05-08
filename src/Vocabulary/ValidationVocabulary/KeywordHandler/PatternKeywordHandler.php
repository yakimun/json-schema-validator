<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class PatternKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var string
     */
    private $pattern;

    /**
     * @param string $absoluteLocation
     * @param string $pattern
     */
    public function __construct(string $absoluteLocation, string $pattern)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->pattern = $pattern;
    }
}
