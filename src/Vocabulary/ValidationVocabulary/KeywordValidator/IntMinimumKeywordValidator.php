<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class IntMinimumKeywordValidator implements KeywordValidator
{
    /**
     * @var int
     */
    private int $minimum;

    /**
     * @param int $minimum
     */
    public function __construct(int $minimum)
    {
        $this->minimum = $minimum;
    }
}
