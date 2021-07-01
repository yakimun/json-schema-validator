<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class IntExclusiveMinimumKeywordValidator implements KeywordValidator
{
    /**
     * @var int
     */
    private int $exclusiveMinimum;

    /**
     * @param int $exclusiveMinimum
     */
    public function __construct(int $exclusiveMinimum)
    {
        $this->exclusiveMinimum = $exclusiveMinimum;
    }
}
