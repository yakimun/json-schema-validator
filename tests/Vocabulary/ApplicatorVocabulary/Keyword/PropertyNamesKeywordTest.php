<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ApplicatorVocabulary\Keyword;

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
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\PropertyNamesKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\PropertyNamesKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\PropertyNamesKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\PropertyNamesKeywordHandler
 */
final class PropertyNamesKeywordTest extends TestCase
{
    /**
     * @var PropertyNamesKeyword
     */
    private $keyword;

    protected function setUp(): void
    {
        $this->keyword = new PropertyNamesKeyword();
    }

    public function testGetName(): void
    {
        $this->assertEquals('propertyNames', $this->keyword->getName());
    }

    public function testProcess(): void
    {
        $uri = new Uri('https://example.com');
        $pointer = new JsonPointer();
        $keywordPointer = new JsonPointer('propertyNames');
        $identifier = new SchemaIdentifier($uri, $pointer);
        $keywordIdentifier = new SchemaIdentifier($uri, $keywordPointer);
        $absoluteLocation = 'https://example.com#/propertyNames';
        $validator = new ObjectSchemaValidator($absoluteLocation, []);
        $keywordHandler = new PropertyNamesKeywordHandler($absoluteLocation, $validator);
        $processedSchema = new ProcessedSchema($validator, $keywordIdentifier, [], [], $keywordPointer);
        $context = new SchemaContext(['propertyNames' => $this->keyword], $identifier);
        $this->keyword->process(['propertyNames' => new JsonObject([])], $pointer, $context);

        $this->assertEquals([$keywordHandler], $context->getKeywordHandlers());
        $this->assertEquals([$processedSchema], $context->getProcessedSchemas());
    }

    public function testProcessWithInvalidValue(): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['propertyNames' => $this->keyword], $identifier);
        $value = new JsonNull();

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['propertyNames' => $value], $pointer, $context);
    }
}
