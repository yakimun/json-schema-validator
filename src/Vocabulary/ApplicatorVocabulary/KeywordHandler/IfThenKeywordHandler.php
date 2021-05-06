<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class IfThenKeywordHandler implements KeywordHandler
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
    private $thenAbsoluteLocation;

    /**
     * @var SchemaValidator
     */
    private $thenSchemaValidator;

    /**
     * @param string $absoluteLocation
     * @param SchemaValidator $schemaValidator
     * @param string $thenAbsoluteLocation
     * @param SchemaValidator $thenSchemaValidator
     */
    public function __construct(
        string $absoluteLocation,
        SchemaValidator $schemaValidator,
        string $thenAbsoluteLocation,
        SchemaValidator $thenSchemaValidator
    ) {
        $this->absoluteLocation = $absoluteLocation;
        $this->schemaValidator = $schemaValidator;
        $this->thenAbsoluteLocation = $thenAbsoluteLocation;
        $this->thenSchemaValidator = $thenSchemaValidator;
    }
}
