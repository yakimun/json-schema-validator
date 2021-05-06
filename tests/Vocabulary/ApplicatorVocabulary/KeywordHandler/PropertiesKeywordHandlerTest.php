<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ApplicatorVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\PropertiesKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\PropertiesKeywordHandler
 */
final class PropertiesKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new PropertiesKeywordHandler('https://example.com#/properties', []);

        $this->assertInstanceOf(PropertiesKeywordHandler::class, $keywordHandler);
    }
}
