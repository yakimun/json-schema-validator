<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ApplicatorVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\NotKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\NotKeywordValidator
 */
final class NotKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = NotKeywordValidator::class;

        $this->assertInstanceOf($expected, new NotKeywordValidator($this->createStub(SchemaValidator::class)));
    }
}
