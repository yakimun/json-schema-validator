<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class MinLengthKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var int
     */
    private $minLength;

    /**
     * @param string $absoluteLocation
     * @param int $minLength
     */
    public function __construct(string $absoluteLocation, int $minLength)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->minLength = $minLength;
    }
}
