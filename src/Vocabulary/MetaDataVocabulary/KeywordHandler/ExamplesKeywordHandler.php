<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class ExamplesKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var list<JsonValue>
     */
    private $examples;

    /**
     * @param string $absoluteLocation
     * @param list<JsonValue> $examples
     */
    public function __construct(string $absoluteLocation, array $examples)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->examples = $examples;
    }
}
