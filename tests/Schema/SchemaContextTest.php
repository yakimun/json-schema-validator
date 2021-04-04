<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Schema;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonPointer;
use Yakimun\JsonSchemaValidator\Json\JsonTrue;
use Yakimun\JsonSchemaValidator\Schema\ProcessedSchema;
use Yakimun\JsonSchemaValidator\Schema\SchemaContext;
use Yakimun\JsonSchemaValidator\Schema\SchemaFactory;
use Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Schema\SchemaReference;
use Yakimun\JsonSchemaValidator\SchemaValidator\TrueSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Schema\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonTrue
 * @uses \Yakimun\JsonSchemaValidator\Schema\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaFactory
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaReference
 * @uses \Yakimun\JsonSchemaValidator\Schema\TrueSchema
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\TrueSchemaValidator
 */
final class SchemaContextTest extends TestCase
{
    /**
     * @var SchemaFactory
     */
    private $factory;

    /**
     * @var SchemaIdentifier
     */
    private $identifier;

    protected function setUp(): void
    {
        $this->factory = new SchemaFactory(['foo' => $this->createStub(Keyword::class)]);
        $this->identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
    }

    public function testGetIdentifier(): void
    {
        $schemaContext = new SchemaContext($this->factory, $this->identifier);

        $this->assertEquals($this->identifier, $schemaContext->getIdentifier());
    }

    public function testSetIdentifier(): void
    {
        $schemaContext = new SchemaContext($this->factory, $this->identifier);
        $identifier = new SchemaIdentifier(new Uri('https://example.org'), new JsonPointer());
        $schemaContext->setIdentifier($identifier);

        $this->assertEquals($identifier, $schemaContext->getIdentifier());
    }

    public function testGetAnchors(): void
    {
        $schemaContext = new SchemaContext($this->factory, $this->identifier);

        $this->assertEquals([], $schemaContext->getAnchors());
    }

    public function testAddAnchor(): void
    {
        $schemaContext = new SchemaContext($this->factory, $this->identifier);
        $anchor = new SchemaReference(new Uri('https://example.com#foo'), new JsonPointer('a'));
        $schemaContext->addAnchor($anchor);

        $this->assertEquals([$anchor], $schemaContext->getAnchors());
    }

    public function testGetReferences(): void
    {
        $schemaContext = new SchemaContext($this->factory, $this->identifier);

        $this->assertEquals([], $schemaContext->getReferences());
    }

    public function testAddReference(): void
    {
        $schemaContext = new SchemaContext($this->factory, $this->identifier);
        $reference = new SchemaReference(new Uri('https://example.com'), new JsonPointer('a'));
        $schemaContext->addReference($reference);

        $this->assertEquals([$reference], $schemaContext->getReferences());
    }

    public function testGetKeywordHandlers(): void
    {
        $schemaContext = new SchemaContext($this->factory, $this->identifier);

        $this->assertEquals([], $schemaContext->getKeywordHandlers());
    }

    public function testAddKeywordHandler(): void
    {
        $keywordHandler = $this->createStub(KeywordHandler::class);
        $schemaContext = new SchemaContext($this->factory, $this->identifier);
        $schemaContext->addKeywordHandler($keywordHandler);

        $this->assertEquals([$keywordHandler], $schemaContext->getKeywordHandlers());
    }

    public function testGetProcessedSchemas(): void
    {
        $schemaContext = new SchemaContext($this->factory, $this->identifier);

        $this->assertEquals([], $schemaContext->getProcessedSchemas());
    }

    public function testCreateValidator(): void
    {
        $schemaContext = new SchemaContext($this->factory, $this->identifier);
        $identifier = new SchemaIdentifier(new Uri('https://example.org'), new JsonPointer('a'));
        $expectedValidator = new TrueSchemaValidator($identifier);
        $expectedProcessedSchema = new ProcessedSchema($expectedValidator, $identifier, [], []);
        $validator = $schemaContext->createValidator(new JsonTrue(new JsonPointer()), $identifier);

        $this->assertEquals($expectedValidator, $validator);
        $this->assertEquals([$expectedProcessedSchema], $schemaContext->getProcessedSchemas());
    }
}
