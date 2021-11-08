<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\ConstKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\ConstKeywordValidator
 */
final class ConstKeywordValidatorTest extends TestCase
{
    public function testGetConst(): void
    {
        $expected = new JsonNull();
        $validator = new ConstKeywordValidator($expected);

        $this->assertSame($expected, $validator->getConst());
    }
}
