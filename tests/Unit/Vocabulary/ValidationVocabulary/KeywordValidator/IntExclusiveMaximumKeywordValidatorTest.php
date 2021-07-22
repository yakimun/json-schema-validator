<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntExclusiveMaximumKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntExclusiveMaximumKeywordValidator
 */
final class IntExclusiveMaximumKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = IntExclusiveMaximumKeywordValidator::class;

        $this->assertInstanceOf($expected, new IntExclusiveMaximumKeywordValidator(0));
    }
}
