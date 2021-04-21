<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Schema;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonPointer;
use Yakimun\JsonSchemaValidator\Schema\ObjectSchema;
use Yakimun\JsonSchemaValidator\Schema\ProcessedSchema;
use Yakimun\JsonSchemaValidator\Schema\SchemaFactory;
use Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\UnknownKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Schema\ObjectSchema
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\Schema\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaFactory
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\UnknownKeywordHandler
 */
final class ObjectSchemaTest extends TestCase
{
    /**
     * @var JsonPointer
     */
    private $pointer;

    /**
     * @var Keyword&MockObject
     */
    private $keyword;

    /**
     * @var non-empty-array<string, Keyword&MockObject>
     */
    private $keywords;

    /**
     * @var SchemaIdentifier
     */
    private $identifier;

    /**
     * @var SchemaFactory
     */
    private $factory;

    protected function setUp(): void
    {
        $this->pointer = new JsonPointer();
        $this->identifier = new SchemaIdentifier(new Uri('https://example.com'), $this->pointer);
        $this->keyword = $this->createMock(Keyword::class);
        $this->keywords = ['foo' => $this->keyword];
        $this->factory = new SchemaFactory($this->keywords);
    }

    public function testProcessWithEmptySchema(): void
    {
        $this->keyword
            ->expects($this->never())
            ->method('process');

        $jsonObject = new JsonObject([], $this->pointer);
        $schema = new ObjectSchema($jsonObject, $this->identifier, $this->factory, $this->keywords);
        $validator = new ObjectSchemaValidator([], $this->identifier);
        $processedSchema = new ProcessedSchema($validator, $this->identifier, [], [], $this->pointer);

        $this->assertEquals([$processedSchema], $schema->process());
    }

    public function testProcessWithKnownKeyword(): void
    {
        $properties = ['foo' => new JsonNull(new JsonPointer('foo'))];

        $this->keyword
            ->expects($this->once())
            ->method('process')
            ->with(
                $this->equalTo($properties),
                $this->anything(),
            );

        $jsonObject = new JsonObject($properties, $this->pointer);
        $schema = new ObjectSchema($jsonObject, $this->identifier, $this->factory, $this->keywords);
        $validator = new ObjectSchemaValidator([], $this->identifier);
        $processedSchema = new ProcessedSchema($validator, $this->identifier, [], [], $this->pointer);

        $this->assertEquals([$processedSchema], $schema->process());
    }

    public function testProcessWithUnknownKeyword(): void
    {
        $properties = ['bar' => new JsonNull(new JsonPointer('bar'))];

        $this->keyword
            ->expects($this->never())
            ->method('process');

        $jsonObject = new JsonObject($properties, $this->pointer);
        $schema = new ObjectSchema($jsonObject, $this->identifier, $this->factory, $this->keywords);
        $keywordValidator = new UnknownKeywordHandler('bar', $properties['bar']);
        $validator = new ObjectSchemaValidator([$keywordValidator], $this->identifier);
        $processedSchema = new ProcessedSchema($validator, $this->identifier, [], [], $this->pointer);

        $this->assertEquals([$processedSchema], $schema->process());
    }
}
