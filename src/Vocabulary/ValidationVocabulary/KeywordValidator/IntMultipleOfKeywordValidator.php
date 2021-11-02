<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class IntMultipleOfKeywordValidator implements KeywordValidator
{
    /**
     * @var int
     */
    private int $multipleOf;

    /**
     * @param int $multipleOf
     */
    public function __construct(int $multipleOf)
    {
        $this->multipleOf = $multipleOf;
    }

    /**
     * @return int
     */
    public function getMultipleOf(): int
    {
        return $this->multipleOf;
    }
}
