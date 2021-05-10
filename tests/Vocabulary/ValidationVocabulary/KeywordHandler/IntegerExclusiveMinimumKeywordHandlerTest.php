<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\IntegerExclusiveMinimumKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\IntegerExclusiveMinimumKeywordHandler
 */
final class IntegerExclusiveMinimumKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new IntegerExclusiveMinimumKeywordHandler('https://example.com#/exclusiveMinimum', 1);

        $this->assertInstanceOf(IntegerExclusiveMinimumKeywordHandler::class, $keywordHandler);
    }
}
