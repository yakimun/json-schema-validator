<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MaxLengthKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MaxLengthKeywordValidator
 */
final class MaxLengthKeywordValidatorTest extends TestCase
{
    public function testGetMaxLength(): void
    {
        $expected = 0;
        $validator = new MaxLengthKeywordValidator($expected);

        $this->assertSame($expected, $validator->getMaxLength());
    }
}
