<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ContentVocabulary;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\ContentVocabulary;
use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\Keyword\ContentEncodingKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\Keyword\ContentMediaTypeKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\Keyword\ContentSchemaKeyword;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\ContentVocabulary
 */
final class ContentVocabularyTest extends TestCase
{
    public function testGetKeywords(): void
    {
        $vocabulary = new ContentVocabulary();
        $expected = [
            ContentEncodingKeyword::NAME => new ContentEncodingKeyword(),
            ContentMediaTypeKeyword::NAME => new ContentMediaTypeKeyword(),
            ContentSchemaKeyword::NAME => new ContentSchemaKeyword(),
        ];

        $this->assertEquals($expected, $vocabulary->getKeywords());
    }
}
