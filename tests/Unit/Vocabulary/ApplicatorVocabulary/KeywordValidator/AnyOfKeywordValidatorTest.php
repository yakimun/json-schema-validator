<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ApplicatorVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\AnyOfKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\AnyOfKeywordValidator
 */
final class AnyOfKeywordValidatorTest extends TestCase
{
    /**
     * @var SchemaValidator
     */
    private SchemaValidator $schemaValidator;

    /**
     * @var AnyOfKeywordValidator
     */
    private AnyOfKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->schemaValidator = $this->createStub(SchemaValidator::class);
        $this->validator = new AnyOfKeywordValidator([$this->schemaValidator]);
    }

    public function testGetSchemaValidators(): void
    {
        $expected = [$this->schemaValidator];

        $this->assertSame($expected, $this->validator->getSchemaValidators());
    }
}
