<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntMultipleOfKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntMultipleOfKeywordValidator
 */
final class IntMultipleOfKeywordValidatorTest extends TestCase
{
    public function testGetMultipleOf(): void
    {
        $expected = 0;
        $validator = new IntMultipleOfKeywordValidator($expected);

        $this->assertSame($expected, $validator->getMultipleOf());
    }
}
