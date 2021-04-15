<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary;

use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class IfThenElseKeywordHandler implements KeywordHandler
{
    /**
     * @var SchemaValidator
     */
    private $schemaValidator;

    /**
     * @var SchemaValidator
     */
    private $thenSchemaValidator;

    /**
     * @var SchemaValidator
     */
    private $elseSchemaValidator;

    /**
     * @param SchemaValidator $schemaValidator
     * @param SchemaValidator $thenSchemaValidator
     * @param SchemaValidator $elseSchemaValidator
     */
    public function __construct(
        SchemaValidator $schemaValidator,
        SchemaValidator $thenSchemaValidator,
        SchemaValidator $elseSchemaValidator
    ) {
        $this->schemaValidator = $schemaValidator;
        $this->thenSchemaValidator = $thenSchemaValidator;
        $this->elseSchemaValidator = $elseSchemaValidator;
    }
}
