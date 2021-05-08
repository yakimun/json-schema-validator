<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class MaxLengthKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var int
     */
    private $maxLength;

    /**
     * @param string $absoluteLocation
     * @param int $maxLength
     */
    public function __construct(string $absoluteLocation, int $maxLength)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->maxLength = $maxLength;
    }
}
