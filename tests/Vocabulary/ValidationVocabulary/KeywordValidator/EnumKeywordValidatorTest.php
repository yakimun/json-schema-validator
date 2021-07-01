<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\EnumKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\EnumKeywordValidator
 */
final class EnumKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = EnumKeywordValidator::class;

        $this->assertInstanceOf($expected, new EnumKeywordValidator([]));
    }
}
