<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class MaxPropertiesKeywordValidator implements KeywordValidator
{
    /**
     * @var int
     */
    private int $maxProperties;

    /**
     * @param int $maxProperties
     */
    public function __construct(int $maxProperties)
    {
        $this->maxProperties = $maxProperties;
    }
}
