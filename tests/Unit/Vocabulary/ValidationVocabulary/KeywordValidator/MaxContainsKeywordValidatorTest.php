<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MaxContainsKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MaxContainsKeywordValidator
 */
final class MaxContainsKeywordValidatorTest extends TestCase
{
    public function testGetMaxContains(): void
    {
        $expected = 0;
        $validator = new MaxContainsKeywordValidator($expected);

        $this->assertSame($expected, $validator->getMaxContains());
    }
}
