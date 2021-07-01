<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\SchemaException;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\ProcessedSchema;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaProcessor;
use Yakimun\JsonSchemaValidator\SchemaReference;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\SchemaReference
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 */
final class SchemaContextTest extends TestCase
{
    /**
     * @var SchemaIdentifier
     */
    private SchemaIdentifier $identifier;

    /**
     * @var SchemaContext
     */
    private SchemaContext $context;

    protected function setUp(): void
    {
        $processor = new SchemaProcessor(['a' => $this->createStub(Keyword::class)]);
        $pointer = new JsonPointer();

        $this->identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer, $pointer);
        $this->context = new SchemaContext($processor, $this->identifier, $pointer);
    }

    public function testGetIdentifier(): void
    {
        $this->assertSame($this->identifier, $this->context->getIdentifier());
    }

    public function testSetIdentifier(): void
    {
        $uri = new Uri('https://example.org');
        $fragment = new JsonPointer();
        $path = new JsonPointer('$id');
        $expected = new SchemaIdentifier($uri, $fragment, $path);
        $this->context->setIdentifier($uri, '$id');

        $this->assertEquals($expected, $this->context->getIdentifier());
    }

    public function testGetPath(): void
    {
        $expected = new JsonPointer();

        $this->assertEquals($expected, $this->context->getPath());
    }

    public function testGetAnchors(): void
    {
        $this->assertSame([], $this->context->getAnchors());
    }

    public function testAddAnchor(): void
    {
        $uri = new Uri('https://example.com#a');
        $path = new JsonPointer('$anchor');
        $expected = [new SchemaReference($uri, $path)];
        $this->context->addAnchor($uri, '$anchor');

        $this->assertEquals($expected, $this->context->getAnchors());
    }

    public function testGetReferences(): void
    {
        $this->assertSame([], $this->context->getReferences());
    }

    public function testAddReference(): void
    {
        $uri = new Uri('https://example.com');
        $path = new JsonPointer('$ref');
        $expected = [new SchemaReference($uri, $path)];
        $this->context->addReference($uri, '$ref');

        $this->assertEquals($expected, $this->context->getReferences());
    }

    public function testGetKeywordValidators(): void
    {
        $this->assertSame([], $this->context->getKeywordValidators());
    }

    public function testAddKeywordValidator(): void
    {
        $validator = $this->createStub(KeywordValidator::class);
        $expected = [$validator];
        $this->context->addKeywordValidator($validator);

        $this->assertEquals($expected, $this->context->getKeywordValidators());
    }

    public function testGetProcessedSchemas(): void
    {
        $this->assertSame([], $this->context->getProcessedSchemas());
    }

    public function testCreateValidator(): void
    {
        $uri = new Uri('https://example.com');
        $pointer = new JsonPointer('a');
        $identifier = new SchemaIdentifier($uri, $pointer, $pointer);
        $expectedValidator = new ObjectSchemaValidator($uri, $pointer, []);
        $expectedProcessedSchemas = [new ProcessedSchema($expectedValidator, $identifier, [], [])];

        $this->assertEquals($expectedValidator, $this->context->createValidator((object)[], 'a'));
        $this->assertEquals($expectedProcessedSchemas, $this->context->getProcessedSchemas());
    }

    public function testCreateException(): void
    {
        $expected = new SchemaException('a', new JsonPointer('b'));

        $this->assertEquals($expected, $this->context->createException('a', 'b'));
    }
}
