<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\ArrayTypeKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\ArrayTypeKeywordHandler
 */
final class ArrayTypeKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new ArrayTypeKeywordHandler('https://example.com/#type', []);

        $this->assertInstanceOf(ArrayTypeKeywordHandler::class, $keywordHandler);
    }
}
