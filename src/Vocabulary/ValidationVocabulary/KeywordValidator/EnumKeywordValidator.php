<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class EnumKeywordValidator implements KeywordValidator
{
    /**
     * @var list<JsonValue>
     */
    private array $elements;

    /**
     * @param list<JsonValue> $elements
     */
    public function __construct(array $elements)
    {
        $this->elements = $elements;
    }

    /**
     * @return list<JsonValue>
     */
    public function getElements(): array
    {
        return $this->elements;
    }
}
