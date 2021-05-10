<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\RequiredKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\RequiredKeywordHandler
 */
final class RequiredKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new RequiredKeywordHandler('https://example.com#/required', []);

        $this->assertInstanceOf(RequiredKeywordHandler::class, $keywordHandler);
    }
}
