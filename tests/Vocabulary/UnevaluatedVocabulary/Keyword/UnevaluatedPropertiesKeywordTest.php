<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\UnevaluatedVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\ProcessedSchema;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\Keyword\UnevaluatedPropertiesKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\KeywordHandler\UnevaluatedPropertiesKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\Keyword\UnevaluatedPropertiesKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\KeywordHandler\UnevaluatedPropertiesKeywordHandler
 */
final class UnevaluatedPropertiesKeywordTest extends TestCase
{
    /**
     * @var UnevaluatedPropertiesKeyword
     */
    private $keyword;

    protected function setUp(): void
    {
        $this->keyword = new UnevaluatedPropertiesKeyword();
    }

    public function testGetName(): void
    {
        $this->assertEquals('unevaluatedProperties', $this->keyword->getName());
    }

    public function testProcess(): void
    {
        $uri = new Uri('https://example.com');
        $pointer = new JsonPointer();
        $keywordPointer = new JsonPointer('unevaluatedProperties');
        $identifier = new SchemaIdentifier($uri, $pointer);
        $keywordIdentifier = new SchemaIdentifier($uri, $keywordPointer);
        $absoluteLocation = 'https://example.com#/unevaluatedProperties';
        $validator = new ObjectSchemaValidator($absoluteLocation, []);
        $keywordHandler = new UnevaluatedPropertiesKeywordHandler($absoluteLocation, $validator);
        $processedSchema = new ProcessedSchema($validator, $keywordIdentifier, [], [], $keywordPointer);
        $context = new SchemaContext(['unevaluatedProperties' => $this->keyword], $identifier);
        $this->keyword->process(['unevaluatedProperties' => new JsonObject([])], $pointer, $context);

        $this->assertEquals([$keywordHandler], $context->getKeywordHandlers());
        $this->assertEquals([$processedSchema], $context->getProcessedSchemas());
    }

    public function testProcessWithInvalidValue(): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['unevaluatedProperties' => $this->keyword], $identifier);
        $value = new JsonNull();

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['unevaluatedProperties' => $value], $pointer, $context);
    }
}
