<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\FloatMinimumKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\FloatMinimumKeywordHandler
 */
final class FloatMinimumKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new FloatMinimumKeywordHandler('https://example.com/#minimum', 1.5);

        $this->assertInstanceOf(FloatMinimumKeywordHandler::class, $keywordHandler);
    }
}
