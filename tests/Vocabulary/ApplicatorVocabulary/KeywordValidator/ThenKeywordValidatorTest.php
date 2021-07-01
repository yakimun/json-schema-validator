<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ApplicatorVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\ThenKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\ThenKeywordValidator
 */
final class ThenKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = ThenKeywordValidator::class;

        $this->assertInstanceOf($expected, new ThenKeywordValidator($this->createStub(SchemaValidator::class)));
    }
}
