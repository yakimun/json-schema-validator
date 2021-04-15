<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary;

use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class OneOfKeywordHandler implements KeywordHandler
{
    /**
     * @var list<SchemaValidator>
     */
    private $schemaValidators;

    /**
     * @param list<SchemaValidator> $schemaValidators
     */
    public function __construct(array $schemaValidators)
    {
        $this->schemaValidators = $schemaValidators;
    }
}
