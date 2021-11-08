<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatMultipleOfKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatMultipleOfKeywordValidator
 */
final class FloatMultipleOfKeywordValidatorTest extends TestCase
{
    public function testGetMultipleOf(): void
    {
        $expected = 0.0;
        $validator = new FloatMultipleOfKeywordValidator($expected);

        $this->assertSame($expected, $validator->getMultipleOf());
    }
}
