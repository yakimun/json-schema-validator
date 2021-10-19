<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
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
     * @var SchemaIdentifier
     */
    private SchemaIdentifier $identifier;

    /**
     * @var SchemaIdentifier
     */
    private SchemaIdentifier $nonCanonicalIdentifier;

    /**
     * @var SchemaContext
     */
    private SchemaContext $context;

    protected function setUp(): void
    {
        $uri = new Uri('https://example1.com');
        $nonCanonicalUri = new Uri('https://example2.com');
        $pointer = new JsonPointer();
        $processor = new SchemaProcessor(['a' => $this->createStub(Keyword::class)]);

        $this->identifier = new SchemaIdentifier($uri, $pointer, $pointer);
        $this->nonCanonicalIdentifier = new SchemaIdentifier($nonCanonicalUri, $pointer, $pointer);
        $this->context = new SchemaContext($processor, $pointer, $this->identifier, [$this->nonCanonicalIdentifier]);
    }

    public function testGetPath(): void
    {
        $expected = new JsonPointer();

        $this->assertEquals($expected, $this->context->getPath());
    }

    public function testGetIdentifier(): void
    {
        $expected = $this->identifier;

        $this->assertSame($expected, $this->context->getIdentifier());
    }

    public function testSetIdentifier(): void
    {
        $uri = new Uri('https://example1.org');
        $fragment = new JsonPointer();
        $path = new JsonPointer('$id');
        $expectedIdentifier = new SchemaIdentifier($uri, $fragment, $path);
        $expectedNonCanonicalIdentifiers = [$this->nonCanonicalIdentifier, $this->identifier];
        $this->context->setIdentifier($uri, '$id');

        $this->assertEquals($expectedIdentifier, $this->context->getIdentifier());
        $this->assertEquals($expectedNonCanonicalIdentifiers, $this->context->getNonCanonicalIdentifiers());
    }

    public function testSetIdentifierWithCurrentUri(): void
    {
        $uri = new Uri('https://example1.com');
        $fragment = new JsonPointer();
        $path = new JsonPointer('$id');
        $expectedIdentifier = new SchemaIdentifier($uri, $fragment, $path);
        $expectedNonCanonicalIdentifiers = [$this->nonCanonicalIdentifier];
        $this->context->setIdentifier($uri, '$id');

        $this->assertEquals($expectedIdentifier, $this->context->getIdentifier());
        $this->assertEquals($expectedNonCanonicalIdentifiers, $this->context->getNonCanonicalIdentifiers());
    }

    public function testGetNonCanonicalIdentifiers(): void
    {
        $expected = [$this->nonCanonicalIdentifier];

        $this->assertEquals($expected, $this->context->getNonCanonicalIdentifiers());
    }

    public function testGetAnchors(): void
    {
        $this->assertEmpty($this->context->getAnchors());
    }

    public function testAddAnchor(): void
    {
        $uri = new Uri('https://example1.com#a');
        $path = new JsonPointer('$anchor');
        $expected = [new SchemaAnchor($uri, false, $path)];
        $this->context->addAnchor($uri, false, '$anchor');

        $this->assertEquals($expected, $this->context->getAnchors());
    }

    public function testGetReferences(): void
    {
        $this->assertEmpty($this->context->getReferences());
    }

    public function testAddReference(): void
    {
        $uri = new Uri('https://example1.com');
        $path = new JsonPointer('$ref');
        $expected = [new SchemaReference($uri, $path)];
        $this->context->addReference($uri, '$ref');

        $this->assertEquals($expected, $this->context->getReferences());
    }

    public function testGetKeywordValidators(): void
    {
        $this->assertEmpty($this->context->getKeywordValidators());
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
        $this->assertEmpty($this->context->getProcessedSchemas());
    }

    public function testCreateValidator(): void
    {
        $uri = new Uri('https://example1.com');
        $nonCanonicalUri = new Uri('https://example2.com');
        $pointer = new JsonPointer('a');
        $identifier = new SchemaIdentifier($uri, $pointer, $pointer);
        $nonCanonicalIdentifier = new SchemaIdentifier($nonCanonicalUri, $pointer, $pointer);
        $expectedValidator = new ObjectSchemaValidator($uri, $pointer, []);
        $expectedProcessedSchemas = [
            new ProcessedSchema(
                $expectedValidator,
                $identifier,
                [$nonCanonicalIdentifier],
                [],
                [],
            ),
        ];

        $this->assertEquals($expectedValidator, $this->context->createValidator((object)[], 'a'));
        $this->assertEquals($expectedProcessedSchemas, $this->context->getProcessedSchemas());
    }

    public function testCreateException(): void
    {
        $expected = new SchemaException('a Path: "/b".');

        $this->assertEquals($expected, $this->context->createException('a', 'b'));
    }
}
