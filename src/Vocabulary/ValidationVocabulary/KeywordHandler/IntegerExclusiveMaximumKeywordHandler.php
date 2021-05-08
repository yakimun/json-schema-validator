<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class IntegerExclusiveMaximumKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var int
     */
    private $exclusiveMaximum;

    /**
     * @param string $absoluteLocation
     * @param int $exclusiveMaximum
     */
    public function __construct(string $absoluteLocation, int $exclusiveMaximum)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->exclusiveMaximum = $exclusiveMaximum;
    }
}
