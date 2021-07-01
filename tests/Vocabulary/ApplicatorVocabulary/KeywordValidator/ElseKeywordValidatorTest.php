<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ApplicatorVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\ElseKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\ElseKeywordValidator
 */
final class ElseKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = ElseKeywordValidator::class;

        $this->assertInstanceOf($expected, new ElseKeywordValidator($this->createStub(SchemaValidator::class)));
    }
}
