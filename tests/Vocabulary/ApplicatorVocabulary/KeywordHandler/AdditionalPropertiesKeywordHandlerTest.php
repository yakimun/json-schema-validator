<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ApplicatorVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\AdditionalPropertiesKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\AdditionalPropertiesKeywordHandler
 */
final class AdditionalPropertiesKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $absoluteLocation = 'https://example.com#/additionalProperties';
        $validator = $this->createStub(SchemaValidator::class);
        $keywordHandler = new AdditionalPropertiesKeywordHandler($absoluteLocation, $validator);

        $this->assertInstanceOf(AdditionalPropertiesKeywordHandler::class, $keywordHandler);
    }
}
