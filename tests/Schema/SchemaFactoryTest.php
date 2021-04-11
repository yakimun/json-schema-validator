<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Schema;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonFalse;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonPointer;
use Yakimun\JsonSchemaValidator\Json\JsonTrue;
use Yakimun\JsonSchemaValidator\Schema\FalseSchema;
use Yakimun\JsonSchemaValidator\Schema\ObjectSchema;
use Yakimun\JsonSchemaValidator\Schema\SchemaFactory;
use Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Schema\TrueSchema;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

/**
 * @covers \Yakimun\JsonSchemaValidator\Schema\SchemaFactory
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonFalse
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonTrue
 * @uses \Yakimun\JsonSchemaValidator\Schema\FalseSchema
 * @uses \Yakimun\JsonSchemaValidator\Schema\ObjectSchema
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\Schema\TrueSchema
 */
final class SchemaFactoryTest extends TestCase
{
    /**
     * @var non-empty-array<string, Keyword&Stub>
     */
    private $keywords;

    /**
     * @var SchemaIdentifier
     */
    private $identifier;

    protected function setUp(): void
    {
        $this->keywords = ['foo' => $this->createStub(Keyword::class)];
        $this->identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
    }

    public function testCreateSchemaWithObjectValue(): void
    {
        $properties = ['foo' => new JsonNull(new JsonPointer('foo'))];
        $schemaFactory = new SchemaFactory($this->keywords);
        $expectedSchema = new ObjectSchema($properties, $this->identifier, $schemaFactory, $this->keywords);
        $schema = $schemaFactory->createSchema(new JsonObject($properties, new JsonPointer()), $this->identifier);

        $this->assertEquals($expectedSchema, $schema);
    }

    public function testCreateSchemaWithTrueValue(): void
    {
        $schemaFactory = new SchemaFactory($this->keywords);
        $schema = $schemaFactory->createSchema(new JsonTrue(new JsonPointer()), $this->identifier);

        $this->assertEquals(new TrueSchema($this->identifier), $schema);
    }

    public function testCreateSchemaWithFalseValue(): void
    {
        $schemaFactory = new SchemaFactory($this->keywords);
        $schema = $schemaFactory->createSchema(new JsonFalse(new JsonPointer()), $this->identifier);

        $this->assertEquals(new FalseSchema($this->identifier), $schema);
    }

    public function testCreateSchemaWithInvalidValue(): void
    {
        $schemaFactory = new SchemaFactory($this->keywords);

        $this->expectException(InvalidSchemaException::class);

        /**
         * @psalm-suppress UnusedMethodCall
         */
        $schemaFactory->createSchema(new JsonNull(new JsonPointer()), $this->identifier);
    }
}
