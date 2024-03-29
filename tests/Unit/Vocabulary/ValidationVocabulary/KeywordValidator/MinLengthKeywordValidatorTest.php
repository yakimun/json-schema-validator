<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MinLengthKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MinLengthKeywordValidator
 */
final class MinLengthKeywordValidatorTest extends TestCase
{
    public function testGetMinLength(): void
    {
        $expected = 0;
        $validator = new MinLengthKeywordValidator($expected);

        $this->assertSame($expected, $validator->getMinLength());
    }
}
