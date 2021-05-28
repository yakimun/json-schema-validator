<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ApplicatorVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\ProcessedSchema;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\ElseKeyword;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\ElseKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 */
final class ElseKeywordTest extends TestCase
{
    /**
     * @var ElseKeyword
     */
    private $keyword;

    protected function setUp(): void
    {
        $this->keyword = new ElseKeyword();
    }

    public function testGetName(): void
    {
        $this->assertEquals('else', $this->keyword->getName());
    }

    public function testProcess(): void
    {
        $uri = new Uri('https://example.com');
        $pointer = new JsonPointer();
        $keywordPointer = new JsonPointer('else');
        $identifier = new SchemaIdentifier($uri, $pointer);
        $keywordIdentifier = new SchemaIdentifier($uri, $keywordPointer);
        $validator = new ObjectSchemaValidator('https://example.com#/else', []);
        $processedSchema = new ProcessedSchema($validator, $keywordIdentifier, [], [], $keywordPointer);
        $context = new SchemaContext(['else' => $this->keyword], $identifier);
        $this->keyword->process(['else' => new JsonObject([])], $pointer, $context);

        $this->assertEmpty($context->getKeywordHandlers());
        $this->assertEquals([$processedSchema], $context->getProcessedSchemas());
    }

    public function testProcessWithIf(): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['else' => $this->keyword], $identifier);
        $expectedContext = new SchemaContext(['else' => $this->keyword], $identifier);
        $this->keyword->process(['if' => new JsonObject([]), 'else' => new JsonObject([])], $pointer, $context);

        $this->assertEquals($expectedContext, $context);
    }
}
