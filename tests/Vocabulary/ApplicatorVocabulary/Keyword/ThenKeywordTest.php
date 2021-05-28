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
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\ThenKeyword;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\ThenKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 */
final class ThenKeywordTest extends TestCase
{
    /**
     * @var ThenKeyword
     */
    private $keyword;

    protected function setUp(): void
    {
        $this->keyword = new ThenKeyword();
    }

    public function testGetName(): void
    {
        $this->assertEquals('then', $this->keyword->getName());
    }

    public function testProcess(): void
    {
        $uri = new Uri('https://example.com');
        $pointer = new JsonPointer();
        $keywordPointer = new JsonPointer('then');
        $identifier = new SchemaIdentifier($uri, $pointer);
        $keywordIdentifier = new SchemaIdentifier($uri, $keywordPointer);
        $validator = new ObjectSchemaValidator('https://example.com#/then', []);
        $processedSchema = new ProcessedSchema($validator, $keywordIdentifier, [], [], $keywordPointer);
        $context = new SchemaContext(['then' => $this->keyword], $identifier);
        $this->keyword->process(['then' => new JsonObject([])], $pointer, $context);

        $this->assertEmpty($context->getKeywordHandlers());
        $this->assertEquals([$processedSchema], $context->getProcessedSchemas());
    }

    public function testProcessWithIf(): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['then' => $this->keyword], $identifier);
        $expectedContext = new SchemaContext(['then' => $this->keyword], $identifier);
        $this->keyword->process(['if' => new JsonObject([]), 'then' => new JsonObject([])], $pointer, $context);

        $this->assertEquals($expectedContext, $context);
    }
}
