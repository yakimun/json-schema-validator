<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\RequiredKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\RequiredKeywordValidator
 */
final class RequiredKeywordValidatorTest extends TestCase
{
    public function testGetRequiredProperties(): void
    {
        $expected = ['a'];
        $validator = new RequiredKeywordValidator($expected);

        $this->assertSame($expected, $validator->getRequiredProperties());
    }
}
