<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class FloatMultipleOfKeywordValidator implements KeywordValidator
{
    /**
     * @var float
     */
    private float $multipleOf;

    /**
     * @param float $multipleOf
     */
    public function __construct(float $multipleOf)
    {
        $this->multipleOf = $multipleOf;
    }
}
