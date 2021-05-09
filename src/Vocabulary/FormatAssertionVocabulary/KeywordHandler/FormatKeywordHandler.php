<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\FormatAssertionVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class FormatKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var string
     */
    private $format;

    /**
     * @param string $absoluteLocation
     * @param string $format
     */
    public function __construct(string $absoluteLocation, string $format)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->format = $format;
    }
}
