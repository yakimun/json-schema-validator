<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\MetaDataVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordHandler\WriteOnlyKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordHandler\WriteOnlyKeywordHandler
 */
final class WriteOnlyKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new WriteOnlyKeywordHandler('https://example.com#/writeOnly', true);

        $this->assertInstanceOf(WriteOnlyKeywordHandler::class, $keywordHandler);
    }
}
