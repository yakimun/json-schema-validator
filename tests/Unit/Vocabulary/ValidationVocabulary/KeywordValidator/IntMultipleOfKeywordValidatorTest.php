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
    public function testConstruct(): void
    {
        $expected = IntMultipleOfKeywordValidator::class;

        $this->assertInstanceOf($expected, new IntMultipleOfKeywordValidator(0));
    }
}
