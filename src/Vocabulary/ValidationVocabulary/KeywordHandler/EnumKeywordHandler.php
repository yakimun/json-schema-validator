<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class EnumKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var list<JsonValue>
     */
    private $elements;

    /**
     * @param string $absoluteLocation
     * @param list<JsonValue> $elements
     */
    public function __construct(string $absoluteLocation, array $elements)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->elements = $elements;
    }
}
