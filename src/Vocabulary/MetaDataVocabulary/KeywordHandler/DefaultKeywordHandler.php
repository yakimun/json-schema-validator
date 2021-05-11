<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class DefaultKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var JsonValue
     */
    private $default;

    /**
     * @param string $absoluteLocation
     * @param JsonValue $default
     */
    public function __construct(string $absoluteLocation, JsonValue $default)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->default = $default;
    }
}
