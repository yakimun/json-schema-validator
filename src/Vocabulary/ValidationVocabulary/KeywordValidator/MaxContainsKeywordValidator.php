<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class MaxContainsKeywordValidator implements KeywordValidator
{
    /**
     * @var int
     */
    private int $maxContains;

    /**
     * @param int $maxContains
     */
    public function __construct(int $maxContains)
    {
        $this->maxContains = $maxContains;
    }
}
