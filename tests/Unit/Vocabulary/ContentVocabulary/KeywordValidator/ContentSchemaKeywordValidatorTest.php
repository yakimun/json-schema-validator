<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ContentVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordValidator\ContentSchemaKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordValidator\ContentSchemaKeywordValidator
 */
final class ContentSchemaKeywordValidatorTest extends TestCase
{
    /**
     * @var SchemaValidator
     */
    private SchemaValidator $schemaValidator;

    /**
     * @var ContentSchemaKeywordValidator
     */
    private ContentSchemaKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->schemaValidator = $this->createStub(SchemaValidator::class);
        $this->validator = new ContentSchemaKeywordValidator($this->schemaValidator);
    }

    public function testGetSchemaValidator(): void
    {
        $expected = $this->schemaValidator;

        $this->assertSame($expected, $this->validator->getSchemaValidator());
    }
}
