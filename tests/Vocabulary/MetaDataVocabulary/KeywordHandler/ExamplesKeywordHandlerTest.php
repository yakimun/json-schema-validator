<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\MetaDataVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordHandler\ExamplesKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordHandler\ExamplesKeywordHandler
 * @uses   \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses   \Yakimun\JsonSchemaValidator\JsonPointer
 */
final class ExamplesKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $values = [new JsonNull(new JsonPointer('examples', '0'))];
        $keywordHandler = new ExamplesKeywordHandler('https://example.com#/examples', $values);

        $this->assertInstanceOf(ExamplesKeywordHandler::class, $keywordHandler);
    }
}
