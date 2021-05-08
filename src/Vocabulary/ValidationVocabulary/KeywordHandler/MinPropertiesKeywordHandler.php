<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class MinPropertiesKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var int
     */
    private $minProperties;

    /**
     * @param string $absoluteLocation
     * @param int $minProperties
     */
    public function __construct(string $absoluteLocation, int $minProperties)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->minProperties = $minProperties;
    }
}
