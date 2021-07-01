<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class ArrayTypeKeywordValidator implements KeywordValidator
{
    /**
     * @var list<'null'|'boolean'|'object'|'array'|'number'|'string'|'integer'>
     */
    private array $types;

    /**
     * @param list<'null'|'boolean'|'object'|'array'|'number'|'string'|'integer'> $types
     */
    public function __construct(array $types)
    {
        $this->types = $types;
    }
}
