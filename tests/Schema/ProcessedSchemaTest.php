<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Schema;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonPointer;
use Yakimun\JsonSchemaValidator\Schema\ProcessedSchema;
use Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Schema\SchemaReference;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\SchemaValidator\TrueSchemaValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Schema\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaReference
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\TrueSchemaValidator
 */
final class ProcessedSchemaTest extends TestCase
{
    /**
     * @var SchemaIdentifier
     */
    private $identifier;

    /**
     * @var SchemaValidator
     */
    private $validator;

    protected function setUp(): void
    {
        $this->identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $this->validator = new TrueSchemaValidator($this->identifier);
    }

    public function testGetValidator(): void
    {
        $processedSchema = new ProcessedSchema($this->validator, $this->identifier, [], []);

        $this->assertEquals($this->validator, $processedSchema->getValidator());
    }

    public function testGetIdentifier(): void
    {
        $processedSchema = new ProcessedSchema($this->validator, $this->identifier, [], []);

        $this->assertEquals($this->identifier, $processedSchema->getIdentifier());
    }

    public function testGetAnchors(): void
    {
        $anchors = [new SchemaReference(new Uri('https://example.com#foo'), new JsonPointer('a'))];
        $processedSchema = new ProcessedSchema($this->validator, $this->identifier, $anchors, []);

        $this->assertEquals($anchors, $processedSchema->getAnchors());
    }

    public function testGetReferences(): void
    {
        $references = [new SchemaReference(new Uri('https://example.com#/a'), new JsonPointer('a'))];
        $processedSchema = new ProcessedSchema($this->validator, $this->identifier, [], $references);

        $this->assertEquals($references, $processedSchema->getReferences());
    }
}
