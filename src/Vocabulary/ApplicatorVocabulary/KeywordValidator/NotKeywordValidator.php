<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class NotKeywordValidator implements KeywordValidator
{
    /**
     * @var SchemaValidator
     */
    private SchemaValidator $schemaValidator;

    /**
     * @param SchemaValidator $schemaValidator
     */
    public function __construct(SchemaValidator $schemaValidator)
    {
        $this->schemaValidator = $schemaValidator;
    }

    /**
     * @return SchemaValidator
     */
    public function getSchemaValidator(): SchemaValidator
    {
        return $this->schemaValidator;
    }
}
