<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class PrefixItemsKeywordValidator implements KeywordValidator
{
    /**
     * @var list<SchemaValidator>
     */
    private array $schemaValidators;

    /**
     * @param list<SchemaValidator> $schemaValidators
     */
    public function __construct(array $schemaValidators)
    {
        $this->schemaValidators = $schemaValidators;
    }

    /**
     * @return list<SchemaValidator>
     */
    public function getSchemaValidators(): array
    {
        return $this->schemaValidators;
    }
}
