<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class FloatMaximumKeywordValidator implements KeywordValidator
{
    /**
     * @var float
     */
    private float $maximum;

    /**
     * @param float $maximum
     */
    public function __construct(float $maximum)
    {
        $this->maximum = $maximum;
    }

    /**
     * @return float
     */
    public function getMaximum(): float
    {
        return $this->maximum;
    }
}
