<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class FloatMultipleOfKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var float
     */
    private $multipleOf;

    /**
     * @param string $absoluteLocation
     * @param float $multipleOf
     */
    public function __construct(string $absoluteLocation, float $multipleOf)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->multipleOf = $multipleOf;
    }
}
