<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\IntegerMultipleOfKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\IntegerMultipleOfKeywordHandler
 */
final class IntegerMultipleOfKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new IntegerMultipleOfKeywordHandler('https://example.com/#multipleOf', 1);

        $this->assertInstanceOf(IntegerMultipleOfKeywordHandler::class, $keywordHandler);
    }
}
