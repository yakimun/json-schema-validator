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
     * @var list<list<mixed>|null|object|scalar>
     */
    private array $elements;

    /**
     * @param list<list<mixed>|null|object|scalar> $elements
     */
    public function __construct(array $elements)
    {
        $this->elements = $elements;
    }

    /**
     * @return list<list<mixed>|null|object|scalar>
     */
    public function getElements(): array
    {
        return $this->elements;
    }
}
