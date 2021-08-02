<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Exception\SchemaException;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\ProcessedSchema;
use Yakimun\JsonSchemaValidator\SchemaAnchor;
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
 * @uses \Yakimun\JsonSchemaValidator\SchemaAnchor
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\SchemaReference
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 */
final class SchemaContextTest extends TestCase
{
    /**
     * @var UriInterface
     */
    private UriInterface $uri;

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

        $this->uri = new Uri('https://example.com');
        $this->identifier = new SchemaIdentifier($this->uri, $pointer, $pointer);
        $this->context = new SchemaContext($processor, $pointer, [$this->identifier]);
    }

    public function testGetPath(): void
    {
        $expected = new JsonPointer();

        $this->assertEquals($expected, $this->context->getPath());
    }

    public function testGetIdentifiers(): void
    {
        $expected = [$this->identifier];

        $this->assertSame($expected, $this->context->getIdentifiers());
    }

    public function testAddIdentifier(): void
    {
        $uri = new Uri('https://example.org');
        $fragment = new JsonPointer();
        $path = new JsonPointer('$id');
        $expected = [$this->identifier, new SchemaIdentifier($uri, $fragment, $path)];
        $this->context->addIdentifier($uri, '$id');

        $this->assertEquals($expected, $this->context->getIdentifiers());
    }

    public function testAddIdentifierWithCurrentUri(): void
    {
        $uri = new Uri('https://example.com');
        $fragment = new JsonPointer();
        $path = new JsonPointer('$id');
        $expected = [new SchemaIdentifier($uri, $fragment, $path)];
        $this->context->addIdentifier($uri, '$id');

        $this->assertEquals($expected, $this->context->getIdentifiers());
    }

    public function testGetAnchors(): void
    {
        $this->assertSame([], $this->context->getAnchors());
    }

    public function testAddAnchor(): void
    {
        $uri = new Uri('https://example.com#a');
        $path = new JsonPointer('$anchor');
        $expected = [new SchemaAnchor($uri, false, $path)];
        $this->context->addAnchor($uri, false, '$anchor');

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
        $expectedProcessedSchemas = [new ProcessedSchema($expectedValidator, [$identifier], [], [])];

        $this->assertEquals($expectedValidator, $this->context->createValidator((object)[], 'a'));
        $this->assertEquals($expectedProcessedSchemas, $this->context->getProcessedSchemas());
    }

    public function testCreateException(): void
    {
        $expected = new SchemaException('a Path: "/b".');

        $this->assertEquals($expected, $this->context->createException('a', 'b'));
    }
}
