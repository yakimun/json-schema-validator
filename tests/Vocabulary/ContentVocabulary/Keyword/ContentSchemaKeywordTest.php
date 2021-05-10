<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ContentVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\ProcessedSchema;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\Keyword\ContentSchemaKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordHandler\ContentSchemaKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\Keyword\ContentSchemaKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonString
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordHandler\ContentSchemaKeywordHandler
 */
final class ContentSchemaKeywordTest extends TestCase
{
    /**
     * @var ContentSchemaKeyword
     */
    private $keyword;

    protected function setUp(): void
    {
        $this->keyword = new ContentSchemaKeyword();
    }

    public function testGetName(): void
    {
        $this->assertEquals('contentSchema', $this->keyword->getName());
    }

    public function testProcess(): void
    {
        $uri = new Uri('https://example.com');
        $pointer = new JsonPointer('contentSchema');
        $absoluteLocation = 'https://example.com#/contentSchema';
        $validator = new ObjectSchemaValidator($absoluteLocation, []);
        $keywordHandler = new ContentSchemaKeywordHandler($absoluteLocation, $validator);
        $processedSchema = new ProcessedSchema($validator, new SchemaIdentifier($uri, $pointer), [], [], $pointer);
        $identifier = new SchemaIdentifier($uri, new JsonPointer());
        $context = new SchemaContext(['contentSchema' => $this->keyword], $identifier);
        $properties = [
            'contentMediaType' => new JsonString('a', new JsonPointer('contentMediaType')),
            'contentSchema' => new JsonObject([], $pointer),
        ];
        $this->keyword->process($properties, $context);

        $this->assertEquals([$keywordHandler], $context->getKeywordHandlers());
        $this->assertEquals([$processedSchema], $context->getProcessedSchemas());
    }

    public function testProcessWithInvalidValue(): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(['contentSchema' => $this->keyword], $identifier);
        $value = new JsonNull(new JsonPointer('contentSchema'));

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['contentSchema' => $value], $context);
    }

    public function testProcessWithoutContentMediaType(): void
    {
        $uri = new Uri('https://example.com');
        $pointer = new JsonPointer('contentSchema');
        $absoluteLocation = 'https://example.com#/contentSchema';
        $validator = new ObjectSchemaValidator($absoluteLocation, []);
        $processedSchema = new ProcessedSchema($validator, new SchemaIdentifier($uri, $pointer), [], [], $pointer);
        $identifier = new SchemaIdentifier($uri, new JsonPointer());
        $context = new SchemaContext(['contentSchema' => $this->keyword], $identifier);
        $this->keyword->process(['contentSchema' => new JsonObject([], $pointer)], $context);

        $this->assertEmpty($context->getKeywordHandlers());
        $this->assertEquals([$processedSchema], $context->getProcessedSchemas());
    }
}
