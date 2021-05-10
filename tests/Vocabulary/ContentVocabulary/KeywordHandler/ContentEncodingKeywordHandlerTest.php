<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ContentVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordHandler\ContentEncodingKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordHandler\ContentEncodingKeywordHandler
 */
final class ContentEncodingKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new ContentEncodingKeywordHandler('https://example.com#/contentEncoding', 'a');

        $this->assertInstanceOf(ContentEncodingKeywordHandler::class, $keywordHandler);
    }
}
