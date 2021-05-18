<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class IntegerMaximumKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var int
     */
    private $maximum;

    /**
     * @param string $absoluteLocation
     * @param int $maximum
     */
    public function __construct(string $absoluteLocation, int $maximum)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->maximum = $maximum;
    }
}