<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ContentVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordValidator\ContentEncodingKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordValidator\ContentEncodingKeywordValidator
 */
final class ContentEncodingKeywordValidatorTest extends TestCase
{
    /**
     * @var string
     */
    private string $contentEncoding;

    /**
     * @var ContentEncodingKeywordValidator
     */
    private ContentEncodingKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->contentEncoding = 'a';
        $this->validator = new ContentEncodingKeywordValidator($this->contentEncoding);
    }

    public function testGetContentEncoding(): void
    {
        $expected = $this->contentEncoding;

        $this->assertSame($expected, $this->validator->getContentEncoding());
    }
}
