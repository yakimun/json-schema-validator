<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\MetaDataVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordHandler\ExamplesKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordHandler\ExamplesKeywordHandler
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 */
final class ExamplesKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new ExamplesKeywordHandler('https://example.com#/examples', [new JsonNull()]);

        $this->assertInstanceOf(ExamplesKeywordHandler::class, $keywordHandler);
    }
}
