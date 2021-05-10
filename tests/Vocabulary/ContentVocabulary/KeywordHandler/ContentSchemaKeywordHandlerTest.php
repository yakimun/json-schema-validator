<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ContentVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordHandler\ContentSchemaKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordHandler\ContentSchemaKeywordHandler
 */
final class ContentSchemaKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $absoluteLocation = 'https://example.com#/contentSchema';
        $validator = $this->createStub(SchemaValidator::class);
        $keywordHandler = new ContentSchemaKeywordHandler($absoluteLocation, $validator);

        $this->assertInstanceOf(ContentSchemaKeywordHandler::class, $keywordHandler);
    }
}
