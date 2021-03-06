<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\FormatAssertionVocabulary;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\FormatAssertionVocabulary\FormatAssertionVocabulary;
use Yakimun\JsonSchemaValidator\Vocabulary\FormatAssertionVocabulary\Keyword\FormatKeyword;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\FormatAssertionVocabulary\FormatAssertionVocabulary
 */
final class FormatAssertionVocabularyTest extends TestCase
{
    public function testGetKeywords(): void
    {
        $vocabulary = new FormatAssertionVocabulary();
        $expected = [
            new FormatKeyword(),
        ];

        $this->assertEquals($expected, $vocabulary->getKeywords());
    }
}
