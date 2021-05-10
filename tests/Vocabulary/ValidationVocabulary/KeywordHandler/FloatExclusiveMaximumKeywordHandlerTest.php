<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\FloatExclusiveMaximumKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\FloatExclusiveMaximumKeywordHandler
 */
final class FloatExclusiveMaximumKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new FloatExclusiveMaximumKeywordHandler('https://example.com#/exclusiveMaximum', 1.5);

        $this->assertInstanceOf(FloatExclusiveMaximumKeywordHandler::class, $keywordHandler);
    }
}
