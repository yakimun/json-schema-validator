<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatExclusiveMaximumKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatExclusiveMaximumKeywordValidator
 */
final class FloatExclusiveMaximumKeywordValidatorTest extends TestCase
{
    public function testGetExclusiveMaximum(): void
    {
        $expected = 0.0;
        $validator = new FloatExclusiveMaximumKeywordValidator($expected);

        $this->assertSame($expected, $validator->getExclusiveMaximum());
    }
}
