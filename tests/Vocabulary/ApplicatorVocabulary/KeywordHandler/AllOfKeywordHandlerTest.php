<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ApplicatorVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\AllOfKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\AllOfKeywordHandler
 */
final class AllOfKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new AllOfKeywordHandler('https://example.com#/allOf', []);

        $this->assertInstanceOf(AllOfKeywordHandler::class, $keywordHandler);
    }
}
