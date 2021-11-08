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
    public function testGetContentEncoding(): void
    {
        $expected = 'a';
        $validator = new ContentEncodingKeywordValidator($expected);

        $this->assertSame($expected, $validator->getContentEncoding());
    }
}
