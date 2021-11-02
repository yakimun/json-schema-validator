<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ContentVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordValidator\ContentMediaTypeKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordValidator\ContentMediaTypeKeywordValidator
 */
final class ContentMediaTypeKeywordValidatorTest extends TestCase
{
    /**
     * @var string
     */
    private string $contentMediaType;

    /**
     * @var ContentMediaTypeKeywordValidator
     */
    private ContentMediaTypeKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->contentMediaType = 'a';
        $this->validator = new ContentMediaTypeKeywordValidator($this->contentMediaType);
    }

    public function testGetContentMediaType(): void
    {
        $expected = $this->contentMediaType;

        $this->assertSame($expected, $this->validator->getContentMediaType());
    }
}
