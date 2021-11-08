<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntExclusiveMinimumKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntExclusiveMinimumKeywordValidator
 */
final class IntExclusiveMinimumKeywordValidatorTest extends TestCase
{
    public function testGetExclusiveMinimum(): void
    {
        $expected = 0;
        $validator = new IntExclusiveMinimumKeywordValidator($expected);

        $this->assertSame($expected, $validator->getExclusiveMinimum());
    }
}
