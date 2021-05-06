<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class UnevaluatedPropertiesKeywordHandler implements KeywordHandler
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
     * @param string $absoluteLocation
     * @param SchemaValidator $schemaValidator
     */
    public function __construct(string $absoluteLocation, SchemaValidator $schemaValidator)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->schemaValidator = $schemaValidator;
    }
}
