<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntMaximumKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntMaximumKeywordValidator
 */
final class IntMaximumKeywordValidatorTest extends TestCase
{
    public function testGetMaximum(): void
    {
        $expected = 0;
        $validator = new IntMaximumKeywordValidator($expected);

        $this->assertSame($expected, $validator->getMaximum());
    }
}
