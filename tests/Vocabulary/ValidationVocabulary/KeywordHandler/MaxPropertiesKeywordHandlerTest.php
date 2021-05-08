<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\MaxPropertiesKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\MaxPropertiesKeywordHandler
 */
final class MaxPropertiesKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new MaxPropertiesKeywordHandler('https://example.com/#maxProperties', 1);

        $this->assertInstanceOf(MaxPropertiesKeywordHandler::class, $keywordHandler);
    }
}
