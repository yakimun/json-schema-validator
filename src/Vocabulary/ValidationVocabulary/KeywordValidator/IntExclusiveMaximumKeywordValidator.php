<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class IntExclusiveMaximumKeywordValidator implements KeywordValidator
{
    /**
     * @var int
     */
    private int $exclusiveMaximum;

    /**
     * @param int $exclusiveMaximum
     */
    public function __construct(int $exclusiveMaximum)
    {
        $this->exclusiveMaximum = $exclusiveMaximum;
    }
}
