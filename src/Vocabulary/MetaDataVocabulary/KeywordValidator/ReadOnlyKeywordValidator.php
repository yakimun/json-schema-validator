<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class ReadOnlyKeywordValidator implements KeywordValidator
{
    /**
     * @var bool
     */
    private bool $readOnly;

    /**
     * @param bool $readOnly
     */
    public function __construct(bool $readOnly)
    {
        $this->readOnly = $readOnly;
    }

    /**
     * @return bool
     */
    public function isReadOnly(): bool
    {
        return $this->readOnly;
    }
}
