<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class PatternPropertiesKeywordValidator implements KeywordValidator
{
    /**
     * @var array<string, SchemaValidator>
     */
    private array $schemaValidators;

    /**
     * @param array<string, SchemaValidator> $schemaValidators
     */
    public function __construct(array $schemaValidators)
    {
        $this->schemaValidators = $schemaValidators;
    }

    /**
     * @return array<string, SchemaValidator>
     */
    public function getSchemaValidators(): array
    {
        return $this->schemaValidators;
    }
}
