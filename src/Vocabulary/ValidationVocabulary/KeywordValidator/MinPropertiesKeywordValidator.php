<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class MinPropertiesKeywordValidator implements KeywordValidator
{
    /**
     * @var int
     */
    private int $minProperties;

    /**
     * @param int $minProperties
     */
    public function __construct(int $minProperties)
    {
        $this->minProperties = $minProperties;
    }

    /**
     * @return int
     */
    public function getMinProperties(): int
    {
        return $this->minProperties;
    }
}
