<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\MaxLengthKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\MaxLengthKeywordHandler
 */
final class MaxLengthKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new MaxLengthKeywordHandler('https://example.com#/maxLength', 1);

        $this->assertInstanceOf(MaxLengthKeywordHandler::class, $keywordHandler);
    }
}
