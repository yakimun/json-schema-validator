<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ApplicatorVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\ContainsKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\ContainsKeywordValidator
 */
final class ContainsKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = ContainsKeywordValidator::class;

        $this->assertInstanceOf($expected, new ContainsKeywordValidator($this->createStub(SchemaValidator::class)));
    }
}
