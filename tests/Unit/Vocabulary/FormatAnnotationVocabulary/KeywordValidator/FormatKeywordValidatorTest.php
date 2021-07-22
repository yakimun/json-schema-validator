<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\FormatAnnotationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\FormatAnnotationVocabulary\KeywordValidator\FormatKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\FormatAnnotationVocabulary\KeywordValidator\FormatKeywordValidator
 */
final class FormatKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = FormatKeywordValidator::class;

        $this->assertInstanceOf($expected, new FormatKeywordValidator('a'));
    }
}
