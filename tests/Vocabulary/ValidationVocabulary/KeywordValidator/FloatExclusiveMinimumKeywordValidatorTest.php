<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatExclusiveMinimumKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatExclusiveMinimumKeywordValidator
 */
final class FloatExclusiveMinimumKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = FloatExclusiveMinimumKeywordValidator::class;

        $this->assertInstanceOf($expected, new FloatExclusiveMinimumKeywordValidator(0));
    }
}
