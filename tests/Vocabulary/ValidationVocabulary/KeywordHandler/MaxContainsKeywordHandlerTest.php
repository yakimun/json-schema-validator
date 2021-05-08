<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\MaxContainsKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\MaxContainsKeywordHandler
 */
final class MaxContainsKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new MaxContainsKeywordHandler('https://example.com/#maxContains', 1);

        $this->assertInstanceOf(MaxContainsKeywordHandler::class, $keywordHandler);
    }
}
