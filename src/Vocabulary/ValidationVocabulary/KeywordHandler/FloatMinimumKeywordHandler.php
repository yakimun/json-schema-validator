<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class FloatMinimumKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var float
     */
    private $minimum;

    /**
     * @param string $absoluteLocation
     * @param float $minimum
     */
    public function __construct(string $absoluteLocation, float $minimum)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->minimum = $minimum;
    }
}
