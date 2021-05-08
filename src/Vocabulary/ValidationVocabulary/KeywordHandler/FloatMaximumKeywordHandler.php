<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class FloatMaximumKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var float
     */
    private $maximum;

    /**
     * @param string $absoluteLocation
     * @param float $maximum
     */
    public function __construct(string $absoluteLocation, float $maximum)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->maximum = $maximum;
    }
}
