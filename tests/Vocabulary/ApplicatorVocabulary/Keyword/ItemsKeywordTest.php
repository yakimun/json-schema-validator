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
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\ItemsKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\ItemsKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\ItemsKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\ItemsKeywordHandler
 */
final class ItemsKeywordTest extends TestCase
{
    /**
     * @var ItemsKeyword
     */
    private $keyword;

    protected function setUp(): void
    {
        $this->keyword = new ItemsKeyword();
    }

    public function testGetName(): void
    {
        $this->assertEquals('items', $this->keyword->getName());
    }

    public function testProcess(): void
    {
        $uri = new Uri('https://example.com');
        $pointer = new JsonPointer('items');
        $absoluteLocation = 'https://example.com#/items';
        $validator = new ObjectSchemaValidator($absoluteLocation, []);
        $keywordHandler = new ItemsKeywordHandler($absoluteLocation, $validator);
        $processedSchema = new ProcessedSchema($validator, new SchemaIdentifier($uri, $pointer), [], [], $pointer);
        $identifier = new SchemaIdentifier($uri, new JsonPointer());
        $context = new SchemaContext(['items' => $this->keyword], $identifier);
        $this->keyword->process(['items' => new JsonObject([], $pointer)], $context);

        $this->assertEquals([$keywordHandler], $context->getKeywordHandlers());
        $this->assertEquals([$processedSchema], $context->getProcessedSchemas());
    }

    public function testProcessWithInvalidValue(): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(['items' => $this->keyword], $identifier);
        $value = new JsonNull(new JsonPointer('items'));

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['items' => $value], $context);
    }
}
