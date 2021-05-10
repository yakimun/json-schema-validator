<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ContentVocabulary;

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
        $keywords = [
            new ContentEncodingKeyword(),
            new ContentMediaTypeKeyword(),
            new ContentSchemaKeyword(),
        ];

        $this->assertEquals($keywords, $vocabulary->getKeywords());
    }
}
