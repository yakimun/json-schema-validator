<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ApplicatorVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\PropertyNamesKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\PropertyNamesKeywordHandler
 */
final class PropertyNamesKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $absoluteLocation = 'https://example.com/#propertyNames';
        $validator = $this->createStub(SchemaValidator::class);
        $keywordHandler = new PropertyNamesKeywordHandler($absoluteLocation, $validator);

        $this->assertInstanceOf(PropertyNamesKeywordHandler::class, $keywordHandler);
    }
}
