<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ApplicatorVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\IfKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\IfKeywordValidator
 */
final class IfKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = IfKeywordValidator::class;

        $this->assertInstanceOf($expected, new IfKeywordValidator($this->createStub(SchemaValidator::class)));
    }
}
