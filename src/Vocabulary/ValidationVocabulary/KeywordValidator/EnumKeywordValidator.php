<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class EnumKeywordValidator implements KeywordValidator
{
    /**
     * @var list<mixed>
     */
    private array $elements;

    /**
     * @param list<mixed> $elements
     */
    public function __construct(array $elements)
    {
        $this->elements = $elements;
    }
}
