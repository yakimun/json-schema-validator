<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\CoreVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordHandler\DynamicRefKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordHandler\DynamicRefKeywordHandler
 */
final class DynamicRefKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new DynamicRefKeywordHandler('https://example.com#/$dynamicRef', 'https://example.com');

        $this->assertInstanceOf(DynamicRefKeywordHandler::class, $keywordHandler);
    }
}
