<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatMinimumKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatMinimumKeywordValidator
 */
final class FloatMinimumKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = FloatMinimumKeywordValidator::class;

        $this->assertInstanceOf($expected, new FloatMinimumKeywordValidator(0));
    }
}
