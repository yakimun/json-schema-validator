<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\PatternKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\PatternKeywordHandler
 */
final class PatternKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new PatternKeywordHandler('https://example.com/#pattern', '/.*/');

        $this->assertInstanceOf(PatternKeywordHandler::class, $keywordHandler);
    }
}
