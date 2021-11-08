<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatMaximumKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatMaximumKeywordValidator
 */
final class FloatMaximumKeywordValidatorTest extends TestCase
{
    public function testGetMaximum(): void
    {
        $expected = 0.0;
        $validator = new FloatMaximumKeywordValidator($expected);

        $this->assertSame($expected, $validator->getMaximum());
    }
}
