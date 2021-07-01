<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MaxLengthKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MaxLengthKeywordValidator
 */
final class MaxLengthKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = MaxLengthKeywordValidator::class;

        $this->assertInstanceOf($expected, new MaxLengthKeywordValidator(0));
    }
}
