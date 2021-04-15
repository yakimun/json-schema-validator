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
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\ThenKeyword;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\ThenKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\Schema\ObjectSchema
 * @uses \Yakimun\JsonSchemaValidator\Schema\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaFactory
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier
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
        $validatorIdentifier = new SchemaIdentifier($uri, new JsonPointer('then'));
        $objectValidator = new ObjectSchemaValidator([], $validatorIdentifier);
        $processedSchema = new ProcessedSchema($objectValidator, $validatorIdentifier, [], []);
        $identifier = new SchemaIdentifier($uri, new JsonPointer());
        $context = new SchemaContext(new SchemaFactory(['then' => $this->keyword]), $identifier);
        $this->keyword->process(['then' => new JsonObject([], new JsonPointer('then'))], $context);

        $this->assertEmpty($context->getKeywordHandlers());
        $this->assertEquals([$processedSchema], $context->getProcessedSchemas());
    }

    public function testProcessWithIf(): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(new SchemaFactory(['then' => $this->keyword]), $identifier);
        $expectedContext = new SchemaContext(new SchemaFactory(['then' => $this->keyword]), $identifier);
        $properties = [
            'if' => new JsonObject([], new JsonPointer('if')),
            'then' => new JsonObject([], new JsonPointer('then')),
        ];
        $this->keyword->process($properties, $context);

        $this->assertEquals($expectedContext, $context);
    }
}
