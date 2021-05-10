<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\FloatMultipleOfKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\FloatMultipleOfKeywordHandler
 */
final class FloatMultipleOfKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new FloatMultipleOfKeywordHandler('https://example.com#/multipleOf', 1.5);

        $this->assertInstanceOf(FloatMultipleOfKeywordHandler::class, $keywordHandler);
    }
}
