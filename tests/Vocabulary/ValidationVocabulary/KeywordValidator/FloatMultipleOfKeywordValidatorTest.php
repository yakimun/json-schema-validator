<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatMultipleOfKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatMultipleOfKeywordValidator
 */
final class FloatMultipleOfKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = FloatMultipleOfKeywordValidator::class;

        $this->assertInstanceOf($expected, new FloatMultipleOfKeywordValidator(0));
    }
}
