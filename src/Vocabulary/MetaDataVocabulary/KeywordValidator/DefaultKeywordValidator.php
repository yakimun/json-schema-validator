<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class DefaultKeywordValidator implements KeywordValidator
{
    /**
     * @var JsonValue
     */
    private JsonValue $default;

    /**
     * @param JsonValue $default
     */
    public function __construct(JsonValue $default)
    {
        $this->default = $default;
    }

    /**
     * @return JsonValue
     */
    public function getDefault(): JsonValue
    {
        return $this->default;
    }
}
