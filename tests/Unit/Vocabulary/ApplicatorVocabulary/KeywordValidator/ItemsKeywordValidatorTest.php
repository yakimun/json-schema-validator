<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ApplicatorVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\ItemsKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\ItemsKeywordValidator
 */
final class ItemsKeywordValidatorTest extends TestCase
{
    /**
     * @var SchemaValidator
     */
    private SchemaValidator $schemaValidator;

    /**
     * @var ItemsKeywordValidator
     */
    private ItemsKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->schemaValidator = $this->createStub(SchemaValidator::class);
        $this->validator = new ItemsKeywordValidator($this->schemaValidator);
    }

    public function testGetSchemaValidator(): void
    {
        $expected = $this->schemaValidator;

        $this->assertSame($expected, $this->validator->getSchemaValidator());
    }
}
