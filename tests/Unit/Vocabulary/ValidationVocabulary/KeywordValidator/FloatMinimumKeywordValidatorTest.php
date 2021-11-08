<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatMinimumKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatMinimumKeywordValidator
 */
final class FloatMinimumKeywordValidatorTest extends TestCase
{
    public function testGetMinimum(): void
    {
        $expected = 0.0;
        $validator = new FloatMinimumKeywordValidator($expected);

        $this->assertSame($expected, $validator->getMinimum());
    }
}
