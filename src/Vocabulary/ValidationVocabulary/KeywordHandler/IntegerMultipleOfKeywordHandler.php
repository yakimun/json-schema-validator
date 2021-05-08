<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class IntegerMultipleOfKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var int
     */
    private $multipleOf;

    /**
     * @param string $absoluteLocation
     * @param int $multipleOf
     */
    public function __construct(string $absoluteLocation, int $multipleOf)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->multipleOf = $multipleOf;
    }
}
