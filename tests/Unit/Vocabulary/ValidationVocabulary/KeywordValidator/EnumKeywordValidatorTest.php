<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\EnumKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\EnumKeywordValidator
 */
final class EnumKeywordValidatorTest extends TestCase
{
    public function testGetElements(): void
    {
        $expected = [new JsonNull()];
        $validator = new EnumKeywordValidator($expected);

        $this->assertSame($expected, $validator->getElements());
    }
}
