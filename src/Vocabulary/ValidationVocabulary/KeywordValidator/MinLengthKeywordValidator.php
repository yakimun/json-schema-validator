<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class MinLengthKeywordValidator implements KeywordValidator
{
    /**
     * @var int
     */
    private int $minLength;

    /**
     * @param int $minLength
     */
    public function __construct(int $minLength)
    {
        $this->minLength = $minLength;
    }

    /**
     * @return int
     */
    public function getMinLength(): int
    {
        return $this->minLength;
    }
}
