<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class MinItemsKeywordValidator implements KeywordValidator
{
    /**
     * @var int
     */
    private int $minItems;

    /**
     * @param int $minItems
     */
    public function __construct(int $minItems)
    {
        $this->minItems = $minItems;
    }

    /**
     * @return int
     */
    public function getMinItems(): int
    {
        return $this->minItems;
    }
}
