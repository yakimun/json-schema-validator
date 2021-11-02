<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class WriteOnlyKeywordValidator implements KeywordValidator
{
    /**
     * @var bool
     */
    private bool $writeOnly;

    /**
     * @param bool $writeOnly
     */
    public function __construct(bool $writeOnly)
    {
        $this->writeOnly = $writeOnly;
    }

    /**
     * @return bool
     */
    public function isWriteOnly(): bool
    {
        return $this->writeOnly;
    }
}
