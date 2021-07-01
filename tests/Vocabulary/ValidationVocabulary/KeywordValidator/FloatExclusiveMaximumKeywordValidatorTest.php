<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatExclusiveMaximumKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatExclusiveMaximumKeywordValidator
 */
final class FloatExclusiveMaximumKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = FloatExclusiveMaximumKeywordValidator::class;

        $this->assertInstanceOf($expected, new FloatExclusiveMaximumKeywordValidator(0));
    }
}
