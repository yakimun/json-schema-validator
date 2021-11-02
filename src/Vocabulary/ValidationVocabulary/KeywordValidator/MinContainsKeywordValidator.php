<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class MinContainsKeywordValidator implements KeywordValidator
{
    /**
     * @var int
     */
    private int $minContains;

    /**
     * @param int $minContains
     */
    public function __construct(int $minContains)
    {
        $this->minContains = $minContains;
    }

    /**
     * @return int
     */
    public function getMinContains(): int
    {
        return $this->minContains;
    }
}
