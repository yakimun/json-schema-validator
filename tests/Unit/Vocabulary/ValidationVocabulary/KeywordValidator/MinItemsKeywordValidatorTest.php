<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MinItemsKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MinItemsKeywordValidator
 */
final class MinItemsKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = MinItemsKeywordValidator::class;

        $this->assertInstanceOf($expected, new MinItemsKeywordValidator(0));
    }
}
