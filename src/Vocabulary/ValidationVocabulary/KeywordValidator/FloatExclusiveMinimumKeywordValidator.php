<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class FloatExclusiveMinimumKeywordValidator implements KeywordValidator
{
    /**
     * @var float
     */
    private float $exclusiveMinimum;

    /**
     * @param float $exclusiveMinimum
     */
    public function __construct(float $exclusiveMinimum)
    {
        $this->exclusiveMinimum = $exclusiveMinimum;
    }

    /**
     * @return float
     */
    public function getExclusiveMinimum(): float
    {
        return $this->exclusiveMinimum;
    }
}
