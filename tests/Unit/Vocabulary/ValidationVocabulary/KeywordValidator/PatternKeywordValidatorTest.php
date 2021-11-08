<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\PatternKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\PatternKeywordValidator
 */
final class PatternKeywordValidatorTest extends TestCase
{
    public function testGetPattern(): void
    {
        $expected = '/a/';
        $validator = new PatternKeywordValidator($expected);

        $this->assertSame($expected, $validator->getPattern());
    }
}
