<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class IfElseKeywordHandler implements KeywordHandler
{
    /**
     * @var SchemaValidator
     */
    private $schemaValidator;

    /**
     * @var SchemaValidator
     */
    private $elseSchemaValidator;

    /**
     * @param SchemaValidator $schemaValidator
     * @param SchemaValidator $elseSchemaValidator
     */
    public function __construct(SchemaValidator $schemaValidator, SchemaValidator $elseSchemaValidator)
    {
        $this->schemaValidator = $schemaValidator;
        $this->elseSchemaValidator = $elseSchemaValidator;
    }
}
