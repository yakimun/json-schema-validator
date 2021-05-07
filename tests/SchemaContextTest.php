<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonBoolean;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\ProcessedSchema;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaReference;
use Yakimun\JsonSchemaValidator\SchemaValidator\BooleanSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonBoolean
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaReference
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\BooleanSchemaValidator
 */
final class SchemaContextTest extends TestCase
{
    /**
     * @var non-empty-array<string, Keyword>
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

    public function testGetIdentifier(): void
    {
        $schemaContext = new SchemaContext($this->keywords, $this->identifier);

        $this->assertEquals($this->identifier, $schemaContext->getIdentifier());
    }

    public function testSetIdentifier(): void
    {
        $schemaContext = new SchemaContext($this->keywords, $this->identifier);
        $identifier = new SchemaIdentifier(new Uri('https://example.org'), new JsonPointer());
        $schemaContext->setIdentifier($identifier);

        $this->assertEquals($identifier, $schemaContext->getIdentifier());
    }

    public function testGetAnchors(): void
    {
        $schemaContext = new SchemaContext($this->keywords, $this->identifier);

        $this->assertEquals([], $schemaContext->getAnchors());
    }

    public function testAddAnchor(): void
    {
        $schemaContext = new SchemaContext($this->keywords, $this->identifier);
        $anchor = new SchemaReference(new Uri('https://example.com#foo'), new JsonPointer('a'));
        $schemaContext->addAnchor($anchor);

        $this->assertEquals([$anchor], $schemaContext->getAnchors());
    }

    public function testGetReferences(): void
    {
        $schemaContext = new SchemaContext($this->keywords, $this->identifier);

        $this->assertEquals([], $schemaContext->getReferences());
    }

    public function testAddReference(): void
    {
        $schemaContext = new SchemaContext($this->keywords, $this->identifier);
        $reference = new SchemaReference(new Uri('https://example.com'), new JsonPointer('a'));
        $schemaContext->addReference($reference);

        $this->assertEquals([$reference], $schemaContext->getReferences());
    }

    public function testGetKeywordHandlers(): void
    {
        $schemaContext = new SchemaContext($this->keywords, $this->identifier);

        $this->assertEquals([], $schemaContext->getKeywordHandlers());
    }

    public function testAddKeywordHandler(): void
    {
        $keywordHandler = $this->createStub(KeywordHandler::class);
        $schemaContext = new SchemaContext($this->keywords, $this->identifier);
        $schemaContext->addKeywordHandler($keywordHandler);

        $this->assertEquals([$keywordHandler], $schemaContext->getKeywordHandlers());
    }

    public function testGetProcessedSchemas(): void
    {
        $schemaContext = new SchemaContext($this->keywords, $this->identifier);

        $this->assertEquals([], $schemaContext->getProcessedSchemas());
    }

    public function testCreateValidator(): void
    {
        $schemaContext = new SchemaContext($this->keywords, $this->identifier);
        $identifier = new SchemaIdentifier(new Uri('https://example.org'), new JsonPointer());
        $expectedValidator = new BooleanSchemaValidator('https://example.org', true);
        $expectedProcessedSchema = new ProcessedSchema($expectedValidator, $identifier, [], [], new JsonPointer('a'));
        $validator = $schemaContext->createValidator(new JsonBoolean(true, new JsonPointer('a')), $identifier);

        $this->assertEquals($expectedValidator, $validator);
        $this->assertEquals([$expectedProcessedSchema], $schemaContext->getProcessedSchemas());
    }
}
