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
    public function testGetMinItems(): void
    {
        $expected = 0;
        $validator = new MinItemsKeywordValidator($expected);

        $this->assertSame($expected, $validator->getMinItems());
    }
}
