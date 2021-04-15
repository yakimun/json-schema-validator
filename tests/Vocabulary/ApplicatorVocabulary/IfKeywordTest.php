<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ApplicatorVocabulary;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonPointer;
use Yakimun\JsonSchemaValidator\Schema\ProcessedSchema;
use Yakimun\JsonSchemaValidator\Schema\SchemaContext;
use Yakimun\JsonSchemaValidator\Schema\SchemaFactory;
use Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\IfElseKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\IfKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\IfKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\IfThenElseKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\IfThenKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\IfKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\Schema\ObjectSchema
 * @uses \Yakimun\JsonSchemaValidator\Schema\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaFactory
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\IfElseKeywordHandler
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\IfKeywordHandler
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\IfThenElseKeywordHandler
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\IfThenKeywordHandler
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
        $identifier = new SchemaIdentifier($uri, new JsonPointer());
        $ifIdentifier = new SchemaIdentifier($uri, new JsonPointer('if'));
        $ifValidator = new ObjectSchemaValidator([], $ifIdentifier);
        $processedSchemas = [new ProcessedSchema($ifValidator, $ifIdentifier, [], [])];
        $context = new SchemaContext(new SchemaFactory(['if' => $this->keyword]), $identifier);
        $this->keyword->process(['if' => new JsonObject([], new JsonPointer('if'))], $context);

        $this->assertEquals([new IfKeywordHandler($ifValidator)], $context->getKeywordHandlers());
        $this->assertEquals($processedSchemas, $context->getProcessedSchemas());
    }

    public function testProcessWithThen(): void
    {
        $uri = new Uri('https://example.com');
        $identifier = new SchemaIdentifier($uri, new JsonPointer());
        $ifIdentifier = new SchemaIdentifier($uri, new JsonPointer('if'));
        $thenIdentifier = new SchemaIdentifier($uri, new JsonPointer('then'));
        $ifValidator = new ObjectSchemaValidator([], $ifIdentifier);
        $thenValidator = new ObjectSchemaValidator([], $thenIdentifier);
        $processedSchemas = [
            new ProcessedSchema($ifValidator, $ifIdentifier, [], []),
            new ProcessedSchema($thenValidator, $thenIdentifier, [], []),
        ];
        $properties = [
            'if' => new JsonObject([], new JsonPointer('if')),
            'then' => new JsonObject([], new JsonPointer('then')),
        ];
        $context = new SchemaContext(new SchemaFactory(['if' => $this->keyword]), $identifier);
        $this->keyword->process($properties, $context);

        $this->assertEquals([new IfThenKeywordHandler($ifValidator, $thenValidator)], $context->getKeywordHandlers());
        $this->assertEquals($processedSchemas, $context->getProcessedSchemas());
    }

    public function testProcessWithElse(): void
    {
        $uri = new Uri('https://example.com');
        $identifier = new SchemaIdentifier($uri, new JsonPointer());
        $ifIdentifier = new SchemaIdentifier($uri, new JsonPointer('if'));
        $elseIdentifier = new SchemaIdentifier($uri, new JsonPointer('else'));
        $ifValidator = new ObjectSchemaValidator([], $ifIdentifier);
        $elseValidator = new ObjectSchemaValidator([], $elseIdentifier);
        $processedSchemas = [
            new ProcessedSchema($ifValidator, $ifIdentifier, [], []),
            new ProcessedSchema($elseValidator, $elseIdentifier, [], []),
        ];
        $properties = [
            'if' => new JsonObject([], new JsonPointer('if')),
            'else' => new JsonObject([], new JsonPointer('else')),
        ];
        $context = new SchemaContext(new SchemaFactory(['if' => $this->keyword]), $identifier);
        $this->keyword->process($properties, $context);

        $this->assertEquals([new IfElseKeywordHandler($ifValidator, $elseValidator)], $context->getKeywordHandlers());
        $this->assertEquals($processedSchemas, $context->getProcessedSchemas());
    }

    public function testProcessWithThenAndElse(): void
    {
        $uri = new Uri('https://example.com');
        $identifier = new SchemaIdentifier($uri, new JsonPointer());
        $ifIdentifier = new SchemaIdentifier($uri, new JsonPointer('if'));
        $thenIdentifier = new SchemaIdentifier($uri, new JsonPointer('then'));
        $elseIdentifier = new SchemaIdentifier($uri, new JsonPointer('else'));
        $ifValidator = new ObjectSchemaValidator([], $ifIdentifier);
        $thenValidator = new ObjectSchemaValidator([], $thenIdentifier);
        $elseValidator = new ObjectSchemaValidator([], $elseIdentifier);
        $keywordHandler = new IfThenElseKeywordHandler($ifValidator, $thenValidator, $elseValidator);
        $processedSchemas = [
            new ProcessedSchema($ifValidator, $ifIdentifier, [], []),
            new ProcessedSchema($thenValidator, $thenIdentifier, [], []),
            new ProcessedSchema($elseValidator, $elseIdentifier, [], []),
        ];
        $properties = [
            'if' => new JsonObject([], new JsonPointer('if')),
            'then' => new JsonObject([], new JsonPointer('then')),
            'else' => new JsonObject([], new JsonPointer('else')),
        ];
        $context = new SchemaContext(new SchemaFactory(['if' => $this->keyword]), $identifier);
        $this->keyword->process($properties, $context);

        $this->assertEquals([$keywordHandler], $context->getKeywordHandlers());
        $this->assertEquals($processedSchemas, $context->getProcessedSchemas());
    }
}
