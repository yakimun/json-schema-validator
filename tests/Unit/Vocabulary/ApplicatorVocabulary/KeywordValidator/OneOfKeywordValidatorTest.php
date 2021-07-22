<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ApplicatorVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\OneOfKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\OneOfKeywordValidator
 */
final class OneOfKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = OneOfKeywordValidator::class;

        $this->assertInstanceOf($expected, new OneOfKeywordValidator([]));
    }
}
