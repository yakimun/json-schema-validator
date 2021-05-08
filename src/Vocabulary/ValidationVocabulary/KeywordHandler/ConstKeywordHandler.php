<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class ConstKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var JsonValue
     */
    private $const;

    /**
     * @param string $absoluteLocation
     * @param JsonValue $const
     */
    public function __construct(string $absoluteLocation, JsonValue $const)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->const = $const;
    }
}
