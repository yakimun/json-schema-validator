<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\UnevaluatedVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\KeywordValidator\UnevaluatedPropertiesKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\KeywordValidator\UnevaluatedPropertiesKeywordValidator
 */
final class UnevaluatedPropertiesKeywordValidatorTest extends TestCase
{
    /**
     * @var SchemaValidator
     */
    private SchemaValidator $schemaValidator;

    /**
     * @var UnevaluatedPropertiesKeywordValidator
     */
    private UnevaluatedPropertiesKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->schemaValidator = $this->createStub(SchemaValidator::class);
        $this->validator = new UnevaluatedPropertiesKeywordValidator($this->schemaValidator);
    }

    public function testGetSchemaValidator(): void
    {
        $expected = $this->schemaValidator;

        $this->assertSame($expected, $this->validator->getSchemaValidator());
    }
}
