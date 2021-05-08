<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class IntegerMinimumKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var int
     */
    private $minimum;

    /**
     * @param string $absoluteLocation
     * @param int $minimum
     */
    public function __construct(string $absoluteLocation, int $minimum)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->minimum = $minimum;
    }
}
