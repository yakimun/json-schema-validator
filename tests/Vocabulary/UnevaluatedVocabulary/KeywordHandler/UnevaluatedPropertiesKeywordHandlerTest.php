<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\UnevaluatedVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\KeywordHandler\UnevaluatedPropertiesKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\KeywordHandler\UnevaluatedPropertiesKeywordHandler
 */
final class UnevaluatedPropertiesKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $absoluteLocation = 'https://example.com/#unevaluatedProperties';
        $validator = $this->createStub(SchemaValidator::class);
        $keywordHandler = new UnevaluatedPropertiesKeywordHandler($absoluteLocation, $validator);

        $this->assertInstanceOf(UnevaluatedPropertiesKeywordHandler::class, $keywordHandler);
    }
}
