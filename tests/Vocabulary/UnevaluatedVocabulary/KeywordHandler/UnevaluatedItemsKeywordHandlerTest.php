<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\UnevaluatedVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\KeywordHandler\UnevaluatedItemsKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\KeywordHandler\UnevaluatedItemsKeywordHandler
 */
final class UnevaluatedItemsKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $absoluteLocation = 'https://example.com#/unevaluatedProperties';
        $validator = $this->createStub(SchemaValidator::class);
        $keywordHandler = new UnevaluatedItemsKeywordHandler($absoluteLocation, $validator);

        $this->assertInstanceOf(UnevaluatedItemsKeywordHandler::class, $keywordHandler);
    }
}
