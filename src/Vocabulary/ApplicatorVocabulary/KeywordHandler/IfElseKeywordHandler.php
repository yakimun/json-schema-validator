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
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var SchemaValidator
     */
    private $schemaValidator;

    /**
     * @var string
     */
    private $elseAbsoluteLocation;

    /**
     * @var SchemaValidator
     */
    private $elseSchemaValidator;

    /**
     * @param string $absoluteLocation
     * @param SchemaValidator $schemaValidator
     * @param string $elseAbsoluteLocation
     * @param SchemaValidator $elseSchemaValidator
     */
    public function __construct(
        string $absoluteLocation,
        SchemaValidator $schemaValidator,
        string $elseAbsoluteLocation,
        SchemaValidator $elseSchemaValidator
    ) {
        $this->absoluteLocation = $absoluteLocation;
        $this->schemaValidator = $schemaValidator;
        $this->elseAbsoluteLocation = $elseAbsoluteLocation;
        $this->elseSchemaValidator = $elseSchemaValidator;
    }
}
