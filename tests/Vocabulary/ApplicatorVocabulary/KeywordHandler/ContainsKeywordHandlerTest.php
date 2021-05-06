<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ApplicatorVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\ContainsKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\ContainsKeywordHandler
 */
final class ContainsKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $absoluteLocation = 'https://example.com#/contains';
        $validator = $this->createStub(SchemaValidator::class);
        $keywordHandler = new ContainsKeywordHandler($absoluteLocation, $validator);

        $this->assertInstanceOf(ContainsKeywordHandler::class, $keywordHandler);
    }
}
