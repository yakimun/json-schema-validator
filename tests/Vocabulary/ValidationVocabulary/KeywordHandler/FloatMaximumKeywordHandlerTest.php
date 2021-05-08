<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\FloatMaximumKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\FloatMaximumKeywordHandler
 */
final class FloatMaximumKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new FloatMaximumKeywordHandler('https://example.com/#maximum', 1.5);

        $this->assertInstanceOf(FloatMaximumKeywordHandler::class, $keywordHandler);
    }
}
