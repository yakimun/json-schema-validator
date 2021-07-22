<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntMaximumKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntMaximumKeywordValidator
 */
final class IntMaximumKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = IntMaximumKeywordValidator::class;

        $this->assertInstanceOf($expected, new IntMaximumKeywordValidator(0));
    }
}
