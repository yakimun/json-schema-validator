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
    /**
     * @var string
     */
    private string $format;

    /**
     * @var FormatKeywordValidator
     */
    private FormatKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->format = 'a';
        $this->validator = new FormatKeywordValidator($this->format);
    }

    public function testGetFormat(): void
    {
        $expected = $this->format;

        $this->assertSame($expected, $this->validator->getFormat());
    }
}
