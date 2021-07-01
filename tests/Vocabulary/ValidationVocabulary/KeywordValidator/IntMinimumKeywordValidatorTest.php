<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntMinimumKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntMinimumKeywordValidator
 */
final class IntMinimumKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = IntMinimumKeywordValidator::class;

        $this->assertInstanceOf($expected, new IntMinimumKeywordValidator(0));
    }
}
