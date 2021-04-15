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
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\ElseKeyword;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\ElseKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\Schema\ObjectSchema
 * @uses \Yakimun\JsonSchemaValidator\Schema\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaFactory
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier
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
        $validatorIdentifier = new SchemaIdentifier($uri, new JsonPointer('else'));
        $objectValidator = new ObjectSchemaValidator([], $validatorIdentifier);
        $processedSchema = new ProcessedSchema($objectValidator, $validatorIdentifier, [], []);
        $identifier = new SchemaIdentifier($uri, new JsonPointer());
        $context = new SchemaContext(new SchemaFactory(['else' => $this->keyword]), $identifier);
        $this->keyword->process(['else' => new JsonObject([], new JsonPointer('else'))], $context);

        $this->assertEmpty($context->getKeywordHandlers());
        $this->assertEquals([$processedSchema], $context->getProcessedSchemas());
    }

    public function testProcessWithIf(): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(new SchemaFactory(['else' => $this->keyword]), $identifier);
        $expectedContext = new SchemaContext(new SchemaFactory(['else' => $this->keyword]), $identifier);
        $properties = [
            'if' => new JsonObject([], new JsonPointer('if')),
            'else' => new JsonObject([], new JsonPointer('else')),
        ];
        $this->keyword->process($properties, $context);

        $this->assertEquals($expectedContext, $context);
    }
}
