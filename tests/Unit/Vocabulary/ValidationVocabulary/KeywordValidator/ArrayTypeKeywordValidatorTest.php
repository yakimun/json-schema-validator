<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\ArrayTypeKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\ArrayTypeKeywordValidator
 */
final class ArrayTypeKeywordValidatorTest extends TestCase
{
    public function testGetTypes(): void
    {
        $expected = ['null'];
        $validator = new ArrayTypeKeywordValidator($expected);

        $this->assertSame($expected, $validator->getTypes());
    }
}
