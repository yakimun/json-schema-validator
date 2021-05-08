<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class IntegerExclusiveMinimumKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var int
     */
    private $exclusiveMinimum;

    /**
     * @param string $absoluteLocation
     * @param int $exclusiveMinimum
     */
    public function __construct(string $absoluteLocation, int $exclusiveMinimum)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->exclusiveMinimum = $exclusiveMinimum;
    }
}
