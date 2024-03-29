<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\FormatAnnotationVocabulary;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\FormatAnnotationVocabulary\FormatAnnotationVocabulary;
use Yakimun\JsonSchemaValidator\Vocabulary\FormatAnnotationVocabulary\Keyword\FormatKeyword;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\FormatAnnotationVocabulary\FormatAnnotationVocabulary
 */
final class FormatAnnotationVocabularyTest extends TestCase
{
    public function testGetKeywords(): void
    {
        $vocabulary = new FormatAnnotationVocabulary();
        $expected = [
            FormatKeyword::NAME => new FormatKeyword(),
        ];

        $this->assertEquals($expected, $vocabulary->getKeywords());
    }
}
