<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class StringTypeKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var 'null'|'boolean'|'object'|'array'|'number'|'string'|'integer'
     */
    private $type;

    /**
     * @param string $absoluteLocation
     * @param 'null'|'boolean'|'object'|'array'|'number'|'string'|'integer' $type
     */
    public function __construct(string $absoluteLocation, string $type)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->type = $type;
    }
}
