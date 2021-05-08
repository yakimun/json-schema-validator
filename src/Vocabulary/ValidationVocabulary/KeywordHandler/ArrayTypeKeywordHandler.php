<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class ArrayTypeKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var list<'null'|'boolean'|'object'|'array'|'number'|'string'|'integer'>
     */
    private $types;

    /**
     * @param string $absoluteLocation
     * @param list<'null'|'boolean'|'object'|'array'|'number'|'string'|'integer'> $types
     */
    public function __construct(string $absoluteLocation, array $types)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->types = $types;
    }
}
