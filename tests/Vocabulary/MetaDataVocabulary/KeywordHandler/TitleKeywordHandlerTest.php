<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\MetaDataVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordHandler\TitleKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordHandler\TitleKeywordHandler
 */
final class TitleKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new TitleKeywordHandler('https://example.com#/title', 'a');

        $this->assertInstanceOf(TitleKeywordHandler::class, $keywordHandler);
    }
}
