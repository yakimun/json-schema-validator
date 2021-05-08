<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\MaxItemsKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\MaxItemsKeywordHandler
 */
final class MaxItemsKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new MaxItemsKeywordHandler('https://example.com/#maxItems', 1);

        $this->assertInstanceOf(MaxItemsKeywordHandler::class, $keywordHandler);
    }
}
