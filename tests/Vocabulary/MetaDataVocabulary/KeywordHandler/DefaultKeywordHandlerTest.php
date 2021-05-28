<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\MetaDataVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordHandler\DefaultKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordHandler\DefaultKeywordHandler
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 */
final class DefaultKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new DefaultKeywordHandler('https://example.com#/default', new JsonNull());

        $this->assertInstanceOf(DefaultKeywordHandler::class, $keywordHandler);
    }
}
