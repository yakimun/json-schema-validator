<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary;

use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class IfThenKeywordHandler implements KeywordHandler
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
     * @param SchemaValidator $schemaValidator
     * @param SchemaValidator $thenSchemaValidator
     */
    public function __construct(SchemaValidator $schemaValidator, SchemaValidator $thenSchemaValidator)
    {
        $this->schemaValidator = $schemaValidator;
        $this->thenSchemaValidator = $thenSchemaValidator;
    }
}
