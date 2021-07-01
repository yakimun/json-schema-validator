<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ApplicatorVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\PropertyNamesKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\PropertyNamesKeywordValidator
 */
final class PropertyNamesKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $validator = new PropertyNamesKeywordValidator($this->createStub(SchemaValidator::class));
        $expected = PropertyNamesKeywordValidator::class;

        $this->assertInstanceOf($expected, $validator);
    }
}
