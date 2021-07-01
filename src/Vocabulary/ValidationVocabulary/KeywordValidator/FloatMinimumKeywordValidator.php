<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class FloatMinimumKeywordValidator implements KeywordValidator
{
    /**
     * @var float
     */
    private float $minimum;

    /**
     * @param float $minimum
     */
    public function __construct(float $minimum)
    {
        $this->minimum = $minimum;
    }
}
