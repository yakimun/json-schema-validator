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
        $pointer = new JsonPointer();
        $keywordPointer = new JsonPointer('if');
        $identifier = new SchemaIdentifier($uri, $pointer);
        $keywordIdentifier = new SchemaIdentifier($uri, $keywordPointer);
        $validator = new ObjectSchemaValidator('https://example.com#/if', []);
        $keywordHandler = new IfKeywordHandler('https://example.com#/if', $validator);
        $processedSchema = new ProcessedSchema($validator, $keywordIdentifier, [], [], $keywordPointer);
        $context = new SchemaContext(['if' => $this->keyword], $identifier);
        $this->keyword->process(['if' => new JsonObject([])], $pointer, $context);

        $this->assertEquals([$keywordHandler], $context->getKeywordHandlers());
        $this->assertEquals([$processedSchema], $context->getProcessedSchemas());
    }

    public function testProcessWithThen(): void
    {
        $absoluteLocation = 'https://example.com#/if';
        $validator = new ObjectSchemaValidator($absoluteLocation, []);
        $thenAbsoluteLocation = 'https://example.com#/then';
        $thenValidator = new ObjectSchemaValidator($thenAbsoluteLocation, []);
        $keywordHandler = new IfThenKeywordHandler(
            $absoluteLocation,
            $validator,
            $thenAbsoluteLocation,
            $thenValidator,
        );
        $uri = new Uri('https://example.com');
        $pointer = new JsonPointer();
        $keywordPointer = new JsonPointer('if');
        $thenKeywordPointer = new JsonPointer('then');
        $identifier = new SchemaIdentifier($uri, $pointer);
        $keywordIdentifier = new SchemaIdentifier($uri, $keywordPointer);
        $thenKeywordIdentifier = new SchemaIdentifier($uri, $thenKeywordPointer);
        $processedSchemas = [
            new ProcessedSchema($validator, $keywordIdentifier, [], [], $keywordPointer),
            new ProcessedSchema($thenValidator, $thenKeywordIdentifier, [], [], $thenKeywordPointer),
        ];
        $context = new SchemaContext(['if' => $this->keyword], $identifier);
        $this->keyword->process(['if' => new JsonObject([]), 'then' => new JsonObject([])], $pointer, $context);

        $this->assertEquals([$keywordHandler], $context->getKeywordHandlers());
        $this->assertEquals($processedSchemas, $context->getProcessedSchemas());
    }

    public function testProcessWithElse(): void
    {
        $absoluteLocation = 'https://example.com#/if';
        $validator = new ObjectSchemaValidator($absoluteLocation, []);
        $elseAbsoluteLocation = 'https://example.com#/else';
        $elseValidator = new ObjectSchemaValidator($elseAbsoluteLocation, []);
        $keywordHandler = new IfElseKeywordHandler(
            $absoluteLocation,
            $validator,
            $elseAbsoluteLocation,
            $elseValidator,
        );
        $uri = new Uri('https://example.com');
        $pointer = new JsonPointer();
        $keywordPointer = new JsonPointer('if');
        $elseKeywordPointer = new JsonPointer('else');
        $identifier = new SchemaIdentifier($uri, $pointer);
        $keywordIdentifier = new SchemaIdentifier($uri, $keywordPointer);
        $elseKeywordIdentifier = new SchemaIdentifier($uri, $elseKeywordPointer);
        $processedSchemas = [
            new ProcessedSchema($validator, $keywordIdentifier, [], [], $keywordPointer),
            new ProcessedSchema($elseValidator, $elseKeywordIdentifier, [], [], $elseKeywordPointer),
        ];
        $context = new SchemaContext(['if' => $this->keyword], $identifier);
        $this->keyword->process(['if' => new JsonObject([]), 'else' => new JsonObject([])], $pointer, $context);

        $this->assertEquals([$keywordHandler], $context->getKeywordHandlers());
        $this->assertEquals($processedSchemas, $context->getProcessedSchemas());
    }

    public function testProcessWithThenAndElse(): void
    {
        $absoluteLocation = 'https://example.com#/if';
        $validator = new ObjectSchemaValidator($absoluteLocation, []);
        $thenAbsoluteLocation = 'https://example.com#/then';
        $thenValidator = new ObjectSchemaValidator($thenAbsoluteLocation, []);
        $elseAbsoluteLocation = 'https://example.com#/else';
        $elseValidator = new ObjectSchemaValidator($elseAbsoluteLocation, []);
        $keywordHandler = new IfThenElseKeywordHandler(
            $absoluteLocation,
            $validator,
            $thenAbsoluteLocation,
            $thenValidator,
            $elseAbsoluteLocation,
            $elseValidator,
        );
        $uri = new Uri('https://example.com');
        $pointer = new JsonPointer();
        $keywordPointer = new JsonPointer('if');
        $thenKeywordPointer = new JsonPointer('then');
        $elseKeywordPointer = new JsonPointer('else');
        $identifier = new SchemaIdentifier($uri, $pointer);
        $keywordIdentifier = new SchemaIdentifier($uri, $keywordPointer);
        $thenKeywordIdentifier = new SchemaIdentifier($uri, $thenKeywordPointer);
        $elseKeywordIdentifier = new SchemaIdentifier($uri, $elseKeywordPointer);
        $processedSchemas = [
            new ProcessedSchema($validator, $keywordIdentifier, [], [], $keywordPointer),
            new ProcessedSchema($thenValidator, $thenKeywordIdentifier, [], [], $thenKeywordPointer),
            new ProcessedSchema($elseValidator, $elseKeywordIdentifier, [], [], $elseKeywordPointer),
        ];
        $properties = ['if' => new JsonObject([]), 'then' => new JsonObject([]), 'else' => new JsonObject([])];
        $context = new SchemaContext(['if' => $this->keyword], $identifier);
        $this->keyword->process($properties, $pointer, $context);

        $this->assertEquals([$keywordHandler], $context->getKeywordHandlers());
        $this->assertEquals($processedSchemas, $context->getProcessedSchemas());
    }
}
