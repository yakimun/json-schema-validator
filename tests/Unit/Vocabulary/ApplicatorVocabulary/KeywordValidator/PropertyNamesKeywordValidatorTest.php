<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ApplicatorVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\PropertyNamesKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\PropertyNamesKeywordValidator
 */
final class PropertyNamesKeywordValidatorTest extends TestCase
{
    /**
     * @var SchemaValidator
     */
    private SchemaValidator $schemaValidator;

    /**
     * @var PropertyNamesKeywordValidator
     */
    private PropertyNamesKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->schemaValidator = $this->createStub(SchemaValidator::class);
        $this->validator = new PropertyNamesKeywordValidator($this->schemaValidator);
    }

    public function testGetSchemaValidator(): void
    {
        $expected = $this->schemaValidator;

        $this->assertSame($expected, $this->validator->getSchemaValidator());
    }
}
