<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\UnevaluatedVocabulary;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonPointer;
use Yakimun\JsonSchemaValidator\Schema\ProcessedSchema;
use Yakimun\JsonSchemaValidator\Schema\SchemaContext;
use Yakimun\JsonSchemaValidator\Schema\SchemaFactory;
use Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\UnevaluatedPropertiesKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\UnevaluatedPropertiesKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\UnevaluatedPropertiesKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\Schema\ObjectSchema
 * @uses \Yakimun\JsonSchemaValidator\Schema\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaFactory
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\UnevaluatedPropertiesKeywordHandler
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
        $identifier = new SchemaIdentifier($uri, new JsonPointer());
        $unevaluatedPropertiesIdentifier = new SchemaIdentifier($uri, new JsonPointer('unevaluatedProperties'));
        $validator = new ObjectSchemaValidator([], $unevaluatedPropertiesIdentifier);
        $processedSchemas = [new ProcessedSchema($validator, $unevaluatedPropertiesIdentifier, [], [])];
        $properties = ['unevaluatedProperties' => new JsonObject([], new JsonPointer('unevaluatedProperties'))];
        $context = new SchemaContext(new SchemaFactory(['unevaluatedProperties' => $this->keyword]), $identifier);
        $this->keyword->process($properties, $context);

        $this->assertEquals([new UnevaluatedPropertiesKeywordHandler($validator)], $context->getKeywordHandlers());
        $this->assertEquals($processedSchemas, $context->getProcessedSchemas());
    }

    public function testProcessWithInvalidValue(): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $properties = ['unevaluatedProperties' => new JsonNull(new JsonPointer('unevaluatedProperties'))];
        $context = new SchemaContext(new SchemaFactory(['unevaluatedProperties' => $this->keyword]), $identifier);

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process($properties, $context);
    }
}
