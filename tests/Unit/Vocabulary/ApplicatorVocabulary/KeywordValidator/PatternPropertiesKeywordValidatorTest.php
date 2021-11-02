<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ApplicatorVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\PatternPropertiesKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\PatternPropertiesKeywordValidator
 */
final class PatternPropertiesKeywordValidatorTest extends TestCase
{
    /**
     * @var string
     */
    private string $key;

    /**
     * @var SchemaValidator
     */
    private SchemaValidator $schemaValidator;

    /**
     * @var PatternPropertiesKeywordValidator
     */
    private PatternPropertiesKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->key = '/a/';
        $this->schemaValidator = $this->createStub(SchemaValidator::class);
        $this->validator = new PatternPropertiesKeywordValidator([$this->key => $this->schemaValidator]);
    }

    public function testGetSchemaValidators(): void
    {
        $expected = [$this->key => $this->schemaValidator];

        $this->assertSame($expected, $this->validator->getSchemaValidators());
    }
}
