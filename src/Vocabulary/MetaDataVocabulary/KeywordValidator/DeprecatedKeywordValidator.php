<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class DeprecatedKeywordValidator implements KeywordValidator
{
    /**
     * @var bool
     */
    private bool $deprecated;

    /**
     * @param bool $deprecated
     */
    public function __construct(bool $deprecated)
    {
        $this->deprecated = $deprecated;
    }

    /**
     * @return bool
     */
    public function isDeprecated(): bool
    {
        return $this->deprecated;
    }
}
