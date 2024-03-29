<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MaxPropertiesKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MaxPropertiesKeywordValidator
 */
final class MaxPropertiesKeywordValidatorTest extends TestCase
{
    public function testGetMaxProperties(): void
    {
        $expected = 0;
        $validator = new MaxPropertiesKeywordValidator($expected);

        $this->assertSame($expected, $validator->getMaxProperties());
    }
}
