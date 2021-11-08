<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class ExamplesKeywordValidator implements KeywordValidator
{
    /**
     * @var list<JsonValue>
     */
    private array $examples;

    /**
     * @param list<JsonValue> $examples
     */
    public function __construct(array $examples)
    {
        $this->examples = $examples;
    }

    /**
     * @return list<JsonValue>
     */
    public function getExamples(): array
    {
        return $this->examples;
    }
}
