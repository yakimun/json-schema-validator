<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ApplicatorVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\AnyOfKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\AnyOfKeywordValidator
 */
final class AnyOfKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = AnyOfKeywordValidator::class;

        $this->assertInstanceOf($expected, new AnyOfKeywordValidator([]));
    }
}
