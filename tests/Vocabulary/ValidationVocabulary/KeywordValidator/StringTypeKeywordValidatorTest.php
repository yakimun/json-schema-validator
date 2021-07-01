<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\StringTypeKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\StringTypeKeywordValidator
 */
final class StringTypeKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = StringTypeKeywordValidator::class;

        $this->assertInstanceOf($expected, new StringTypeKeywordValidator('null'));
    }
}
