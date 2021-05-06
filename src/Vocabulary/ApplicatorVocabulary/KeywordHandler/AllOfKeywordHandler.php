<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class AllOfKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var list<SchemaValidator>
     */
    private $schemaValidators;

    /**
     * @param string $absoluteLocation
     * @param list<SchemaValidator> $schemaValidators
     */
    public function __construct(string $absoluteLocation, array $schemaValidators)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->schemaValidators = $schemaValidators;
    }
}
