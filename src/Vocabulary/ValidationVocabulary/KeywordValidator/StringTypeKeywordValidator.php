<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class StringTypeKeywordValidator implements KeywordValidator
{
    /**
     * @var 'null'|'boolean'|'object'|'array'|'number'|'string'|'integer'
     */
    private string $type;

    /**
     * @param 'null'|'boolean'|'object'|'array'|'number'|'string'|'integer' $type
     */
    public function __construct(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return 'null'|'boolean'|'object'|'array'|'number'|'string'|'integer'
     */
    public function getType(): string
    {
        return $this->type;
    }
}
