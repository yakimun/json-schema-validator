<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\FloatExclusiveMinimumKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\FloatExclusiveMinimumKeywordHandler
 */
final class FloatExclusiveMinimumKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new FloatExclusiveMinimumKeywordHandler('https://example.com/#exclusiveMinimum', 1.5);

        $this->assertInstanceOf(FloatExclusiveMinimumKeywordHandler::class, $keywordHandler);
    }
}
