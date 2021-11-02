<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class FloatExclusiveMaximumKeywordValidator implements KeywordValidator
{
    /**
     * @var float
     */
    private float $exclusiveMaximum;

    /**
     * @param float $exclusiveMaximum
     */
    public function __construct(float $exclusiveMaximum)
    {
        $this->exclusiveMaximum = $exclusiveMaximum;
    }

    /**
     * @return float
     */
    public function getExclusiveMaximum(): float
    {
        return $this->exclusiveMaximum;
    }
}
