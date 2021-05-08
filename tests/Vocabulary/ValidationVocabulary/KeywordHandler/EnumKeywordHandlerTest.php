<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\EnumKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\EnumKeywordHandler
 */
final class EnumKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new EnumKeywordHandler('https://example.com/#enum', []);

        $this->assertInstanceOf(EnumKeywordHandler::class, $keywordHandler);
    }
}
