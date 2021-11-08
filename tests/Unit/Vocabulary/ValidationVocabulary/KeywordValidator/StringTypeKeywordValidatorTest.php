<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\StringTypeKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\StringTypeKeywordValidator
 */
final class StringTypeKeywordValidatorTest extends TestCase
{
    public function testGetType(): void
    {
        $expected = 'null';
        $validator = new StringTypeKeywordValidator($expected);

        $this->assertSame($expected, $validator->getType());
    }
}
