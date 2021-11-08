<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class ConstKeywordValidator implements KeywordValidator
{
    /**
     * @var JsonValue
     */
    private JsonValue $const;

    /**
     * @param JsonValue $const
     */
    public function __construct(JsonValue $const)
    {
        $this->const = $const;
    }

    /**
     * @return JsonValue
     */
    public function getConst(): JsonValue
    {
        return $this->const;
    }
}
