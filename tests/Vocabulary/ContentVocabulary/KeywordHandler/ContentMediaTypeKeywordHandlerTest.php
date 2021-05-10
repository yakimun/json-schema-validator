<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ContentVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordHandler\ContentMediaTypeKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordHandler\ContentMediaTypeKeywordHandler
 */
final class ContentMediaTypeKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new ContentMediaTypeKeywordHandler('https://example.com#/contentMediaType', 'a');

        $this->assertInstanceOf(ContentMediaTypeKeywordHandler::class, $keywordHandler);
    }
}
