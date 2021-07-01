<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MaxItemsKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MaxItemsKeywordValidator
 */
final class MaxItemsKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = MaxItemsKeywordValidator::class;

        $this->assertInstanceOf($expected, new MaxItemsKeywordValidator(0));
    }
}
