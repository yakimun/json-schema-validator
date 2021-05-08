<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\ConstKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\ConstKeywordHandler
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 */
final class ConstKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new ConstKeywordHandler('https://example.com/#const', new JsonNull(new JsonPointer()));

        $this->assertInstanceOf(ConstKeywordHandler::class, $keywordHandler);
    }
}
