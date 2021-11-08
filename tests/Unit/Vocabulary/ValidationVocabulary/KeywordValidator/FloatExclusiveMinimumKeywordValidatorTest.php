<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatExclusiveMinimumKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatExclusiveMinimumKeywordValidator
 */
final class FloatExclusiveMinimumKeywordValidatorTest extends TestCase
{
    public function testGetExclusiveMinimum(): void
    {
        $expected = 0.0;
        $validator = new FloatExclusiveMinimumKeywordValidator($expected);

        $this->assertSame($expected, $validator->getExclusiveMinimum());
    }
}
