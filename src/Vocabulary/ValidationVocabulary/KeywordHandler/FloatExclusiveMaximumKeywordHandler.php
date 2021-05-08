<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class FloatExclusiveMaximumKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var float
     */
    private $exclusiveMaximum;

    /**
     * @param string $absoluteLocation
     * @param float $exclusiveMaximum
     */
    public function __construct(string $absoluteLocation, float $exclusiveMaximum)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->exclusiveMaximum = $exclusiveMaximum;
    }
}
