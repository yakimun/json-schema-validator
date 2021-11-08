<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MinContainsKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MinContainsKeywordValidator
 */
final class MinContainsKeywordValidatorTest extends TestCase
{
    public function testGetMinContains(): void
    {
        $expected = 0;
        $validator = new MinContainsKeywordValidator($expected);

        $this->assertSame($expected, $validator->getMinContains());
    }
}
