<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary;

use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class NotKeywordHandler implements KeywordHandler
{
    /**
     * @var SchemaValidator
     */
    private $schemaValidator;

    /**
     * @param SchemaValidator $schemaValidator
     */
    public function __construct(SchemaValidator $schemaValidator)
    {
        $this->schemaValidator = $schemaValidator;
    }
}
