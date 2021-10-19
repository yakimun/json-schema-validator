<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Exception\SchemaException;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\ProcessedSchema;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaProcessor;
use Yakimun\JsonSchemaValidator\SchemaValidator\BooleanSchemaValidator;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\UnknownKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\BooleanSchemaValidator
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\UnknownKeywordValidator
 */
final class SchemaProcessorTest extends TestCase
{
    /**
     * @var UriInterface
     */
    private UriInterface $uri;

    /**
     * @var JsonPointer
     */
    private JsonPointer $pointer;

    /**
     * @var SchemaIdentifier
     */
    private SchemaIdentifier $identifier;

    /**
     * @var Keyword&MockObject
     */
    private Keyword $keyword;

    /**
     * @var SchemaProcessor
     */
    private SchemaProcessor $processor;

    protected function setUp(): void
    {
        $this->uri = new Uri('https://example.com');
        $this->pointer = new JsonPointer();
        $this->identifier = new SchemaIdentifier($this->uri, $this->pointer, $this->pointer);
        $this->keyword = $this->createMock(Keyword::class);
        $this->processor = new SchemaProcessor(['a' => $this->keyword]);
    }

    public function testProcessWithEmptyObjectSchema(): void
    {
        $this->keyword
            ->expects($this->never())
            ->method('process');

        $schema = (object)[];
        $validator = new ObjectSchemaValidator($this->uri, $this->pointer, []);
        $expected = [new ProcessedSchema($validator, $this->identifier, [], [], [])];

        $this->assertEquals($expected, $this->processor->process($schema, $this->identifier, [], $this->pointer));
    }

    public function testProcessWithKnownKeyword(): void
    {
        $properties = ['a' => null];

        $this->keyword
            ->expects($this->once())
            ->method('process')
            ->with($properties, $this->anything());

        $schema = (object)$properties;
        $validator = new ObjectSchemaValidator($this->uri, $this->pointer, []);
        $expected = [new ProcessedSchema($validator, $this->identifier, [], [], [])];

        $this->assertEquals($expected, $this->processor->process($schema, $this->identifier, [], $this->pointer));
    }

    public function testProcessWithUnknownKeyword(): void
    {
        $this->keyword
            ->expects($this->never())
            ->method('process');

        $schema = (object)['b' => null];
        $keywordValidator = new UnknownKeywordValidator('b', null);
        $validator = new ObjectSchemaValidator($this->uri, $this->pointer, [$keywordValidator]);
        $expected = [new ProcessedSchema($validator, $this->identifier, [], [], [])];

        $this->assertEquals($expected, $this->processor->process($schema, $this->identifier, [], $this->pointer));
    }

    public function testProcessWithBooleanSchema(): void
    {
        $validator = new BooleanSchemaValidator($this->uri, $this->pointer, true);
        $expected = [new ProcessedSchema($validator, $this->identifier, [], [], [])];

        $this->assertEquals($expected, $this->processor->process(true, $this->identifier, [], $this->pointer));
    }

    public function testProcessWithInvalidSchema(): void
    {
        $this->expectException(SchemaException::class);

        $this->processor->process(null, $this->identifier, [], $this->pointer);
    }
}
