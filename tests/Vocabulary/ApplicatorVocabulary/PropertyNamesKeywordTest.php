<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ApplicatorVocabulary;

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
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\PropertyNamesKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\PropertyNamesKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\PropertyNamesKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\Schema\ObjectSchema
 * @uses \Yakimun\JsonSchemaValidator\Schema\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaFactory
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\PropertyNamesKeywordHandler
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
        $validatorIdentifier = new SchemaIdentifier($uri, new JsonPointer('propertyNames'));
        $objectValidator = new ObjectSchemaValidator([], $validatorIdentifier);
        $processedSchema = new ProcessedSchema($objectValidator, $validatorIdentifier, [], []);
        $identifier = new SchemaIdentifier($uri, new JsonPointer());
        $context = new SchemaContext(new SchemaFactory(['propertyNames' => $this->keyword]), $identifier);
        $this->keyword->process(['propertyNames' => new JsonObject([], new JsonPointer('propertyNames'))], $context);

        $this->assertEquals([new PropertyNamesKeywordHandler($objectValidator)], $context->getKeywordHandlers());
        $this->assertEquals([$processedSchema], $context->getProcessedSchemas());
    }

    public function testProcessWithInvalidValue(): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(new SchemaFactory(['propertyNames' => $this->keyword]), $identifier);

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['propertyNames' => new JsonNull(new JsonPointer('propertyNames'))], $context);
    }
}
