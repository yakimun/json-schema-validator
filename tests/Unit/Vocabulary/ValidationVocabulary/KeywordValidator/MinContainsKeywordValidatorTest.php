<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MinContainsKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MinContainsKeywordValidator
 */
final class MinContainsKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = MinContainsKeywordValidator::class;

        $this->assertInstanceOf($expected, new MinContainsKeywordValidator(0));
    }
}
