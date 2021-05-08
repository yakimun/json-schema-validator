<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\IntegerExclusiveMaximumKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\IntegerExclusiveMaximumKeywordHandler
 */
final class IntegerExclusiveMaximumKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new IntegerExclusiveMaximumKeywordHandler('https://example.com/#exclusiveMaximum', 1);

        $this->assertInstanceOf(IntegerExclusiveMaximumKeywordHandler::class, $keywordHandler);
    }
}
