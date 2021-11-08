<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MaxItemsKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MaxItemsKeywordValidator
 */
final class MaxItemsKeywordValidatorTest extends TestCase
{
    public function testGetMaxItems(): void
    {
        $expected = 0;
        $validator = new MaxItemsKeywordValidator($expected);

        $this->assertSame($expected, $validator->getMaxItems());
    }
}
