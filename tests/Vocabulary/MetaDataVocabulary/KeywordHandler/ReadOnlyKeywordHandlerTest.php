<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\MetaDataVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordHandler\ReadOnlyKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordHandler\ReadOnlyKeywordHandler
 */
final class ReadOnlyKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new ReadOnlyKeywordHandler('https://example.com#/readOnly', true);

        $this->assertInstanceOf(ReadOnlyKeywordHandler::class, $keywordHandler);
    }
}
