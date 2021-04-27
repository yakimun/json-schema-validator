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
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\IfKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\IfElseKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\IfKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\IfThenElseKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\IfThenKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\IfKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\IfElseKeywordHandler
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\IfKeywordHandler
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\IfThenElseKeywordHandler
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\IfThenKeywordHandler
 */
final class IfKeywordTest extends TestCase
{
    /**
     * @var IfKeyword
     */
    private $keyword;

    protected function setUp(): void
    {
        $this->keyword = new IfKeyword();
    }

    public function testGetName(): void
    {
        $this->assertEquals('if', $this->keyword->getName());
    }

    public function testProcess(): void
    {
        $uri = new Uri('https://example.com');
        $pointer = new JsonPointer('if');
        $identifier = new SchemaIdentifier($uri, new JsonPointer());
        $ifIdentifier = new SchemaIdentifier($uri, $pointer);
        $ifValidator = new ObjectSchemaValidator([], $ifIdentifier);
        $processedSchemas = [new ProcessedSchema($ifValidator, $ifIdentifier, [], [], $pointer)];
        $context = new SchemaContext(['if' => $this->keyword], $identifier);
        $this->keyword->process(['if' => new JsonObject([], $pointer)], $context);

        $this->assertEquals([new IfKeywordHandler($ifValidator)], $context->getKeywordHandlers());
        $this->assertEquals($processedSchemas, $context->getProcessedSchemas());
    }

    public function testProcessWithThen(): void
    {
        $uri = new Uri('https://example.com');
        $ifPointer = new JsonPointer('if');
        $thenPointer = new JsonPointer('then');
        $identifier = new SchemaIdentifier($uri, new JsonPointer());
        $ifIdentifier = new SchemaIdentifier($uri, $ifPointer);
        $thenIdentifier = new SchemaIdentifier($uri, $thenPointer);
        $ifValidator = new ObjectSchemaValidator([], $ifIdentifier);
        $thenValidator = new ObjectSchemaValidator([], $thenIdentifier);
        $processedSchemas = [
            new ProcessedSchema($ifValidator, $ifIdentifier, [], [], $ifPointer),
            new ProcessedSchema($thenValidator, $thenIdentifier, [], [], $thenPointer),
        ];
        $properties = [
            'if' => new JsonObject([], $ifPointer),
            'then' => new JsonObject([], $thenPointer),
        ];
        $context = new SchemaContext(['if' => $this->keyword], $identifier);
        $this->keyword->process($properties, $context);

        $this->assertEquals([new IfThenKeywordHandler($ifValidator, $thenValidator)], $context->getKeywordHandlers());
        $this->assertEquals($processedSchemas, $context->getProcessedSchemas());
    }

    public function testProcessWithElse(): void
    {
        $uri = new Uri('https://example.com');
        $ifPointer = new JsonPointer('if');
        $elsePointer = new JsonPointer('else');
        $identifier = new SchemaIdentifier($uri, new JsonPointer());
        $ifIdentifier = new SchemaIdentifier($uri, $ifPointer);
        $elseIdentifier = new SchemaIdentifier($uri, $elsePointer);
        $ifValidator = new ObjectSchemaValidator([], $ifIdentifier);
        $elseValidator = new ObjectSchemaValidator([], $elseIdentifier);
        $processedSchemas = [
            new ProcessedSchema($ifValidator, $ifIdentifier, [], [], $ifPointer),
            new ProcessedSchema($elseValidator, $elseIdentifier, [], [], $elsePointer),
        ];
        $properties = [
            'if' => new JsonObject([], $ifPointer),
            'else' => new JsonObject([], $elsePointer),
        ];
        $context = new SchemaContext(['if' => $this->keyword], $identifier);
        $this->keyword->process($properties, $context);

        $this->assertEquals([new IfElseKeywordHandler($ifValidator, $elseValidator)], $context->getKeywordHandlers());
        $this->assertEquals($processedSchemas, $context->getProcessedSchemas());
    }

    public function testProcessWithThenAndElse(): void
    {
        $uri = new Uri('https://example.com');
        $ifPointer = new JsonPointer('if');
        $thenPointer = new JsonPointer('then');
        $elsePointer = new JsonPointer('else');
        $identifier = new SchemaIdentifier($uri, new JsonPointer());
        $ifIdentifier = new SchemaIdentifier($uri, $ifPointer);
        $thenIdentifier = new SchemaIdentifier($uri, $thenPointer);
        $elseIdentifier = new SchemaIdentifier($uri, $elsePointer);
        $ifValidator = new ObjectSchemaValidator([], $ifIdentifier);
        $thenValidator = new ObjectSchemaValidator([], $thenIdentifier);
        $elseValidator = new ObjectSchemaValidator([], $elseIdentifier);
        $keywordHandler = new IfThenElseKeywordHandler($ifValidator, $thenValidator, $elseValidator);
        $processedSchemas = [
            new ProcessedSchema($ifValidator, $ifIdentifier, [], [], $ifPointer),
            new ProcessedSchema($thenValidator, $thenIdentifier, [], [], $thenPointer),
            new ProcessedSchema($elseValidator, $elseIdentifier, [], [], $elsePointer),
        ];
        $properties = [
            'if' => new JsonObject([], $ifPointer),
            'then' => new JsonObject([], $thenPointer),
            'else' => new JsonObject([], $elsePointer),
        ];
        $context = new SchemaContext(['if' => $this->keyword], $identifier);
        $this->keyword->process($properties, $context);

        $this->assertEquals([$keywordHandler], $context->getKeywordHandlers());
        $this->assertEquals($processedSchemas, $context->getProcessedSchemas());
    }
}
