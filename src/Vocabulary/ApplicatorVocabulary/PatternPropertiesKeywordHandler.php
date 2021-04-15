<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary;

use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class PatternPropertiesKeywordHandler implements KeywordHandler
{
    /**
     * @var array<string, SchemaValidator>
     */
    private $schemaValidators;

    /**
     * @param array<string, SchemaValidator> $schemaValidators
     */
    public function __construct(array $schemaValidators)
    {
        $this->schemaValidators = $schemaValidators;
    }
}
