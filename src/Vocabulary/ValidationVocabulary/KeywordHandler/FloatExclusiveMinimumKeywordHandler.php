<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class FloatExclusiveMinimumKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var float
     */
    private $exclusiveMinimum;

    /**
     * @param string $absoluteLocation
     * @param float $exclusiveMinimum
     */
    public function __construct(string $absoluteLocation, float $exclusiveMinimum)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->exclusiveMinimum = $exclusiveMinimum;
    }
}
