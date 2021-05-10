<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\UniqueItemsKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\UniqueItemsKeywordHandler
 */
final class UniqueItemsKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new UniqueItemsKeywordHandler('https://example.com#/uniqueItems', true);

        $this->assertInstanceOf(UniqueItemsKeywordHandler::class, $keywordHandler);
    }
}
