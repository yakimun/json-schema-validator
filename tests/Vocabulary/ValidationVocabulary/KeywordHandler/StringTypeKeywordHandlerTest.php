<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\StringTypeKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\StringTypeKeywordHandler
 */
final class StringTypeKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new StringTypeKeywordHandler('https://example.com/#type', 'null');

        $this->assertInstanceOf(StringTypeKeywordHandler::class, $keywordHandler);
    }
}
