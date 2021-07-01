<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\ArrayTypeKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\ArrayTypeKeywordValidator
 */
final class ArrayTypeKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = ArrayTypeKeywordValidator::class;

        $this->assertInstanceOf($expected, new ArrayTypeKeywordValidator([]));
    }
}
