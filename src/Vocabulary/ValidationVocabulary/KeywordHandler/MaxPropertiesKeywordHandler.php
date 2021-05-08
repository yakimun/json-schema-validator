<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class MaxPropertiesKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var int
     */
    private $maxProperties;

    /**
     * @param string $absoluteLocation
     * @param int $maxProperties
     */
    public function __construct(string $absoluteLocation, int $maxProperties)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->maxProperties = $maxProperties;
    }
}
