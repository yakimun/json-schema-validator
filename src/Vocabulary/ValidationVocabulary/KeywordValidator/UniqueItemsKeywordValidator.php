<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class UniqueItemsKeywordValidator implements KeywordValidator
{
    /**
     * @var bool
     */
    private bool $uniqueItems;

    /**
     * @param bool $uniqueItems
     */
    public function __construct(bool $uniqueItems)
    {
        $this->uniqueItems = $uniqueItems;
    }
}
