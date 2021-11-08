<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntMinimumKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntMinimumKeywordValidator
 */
final class IntMinimumKeywordValidatorTest extends TestCase
{
    public function testGetMinimum(): void
    {
        $expected = 0;
        $validator = new IntMinimumKeywordValidator($expected);

        $this->assertSame($expected, $validator->getMinimum());
    }
}
