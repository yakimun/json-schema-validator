<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\ProcessedSchema;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaReference;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaReference
 */
final class ProcessedSchemaTest extends TestCase
{
    /**
     * @var SchemaValidator
     */
    private SchemaValidator $validator;

    /**
     * @var SchemaIdentifier
     */
    private SchemaIdentifier $identifier;

    /**
     * @var SchemaReference
     */
    private SchemaReference $anchor;

    /**
     * @var SchemaReference
     */
    private SchemaReference $reference;

    /**
     * @var ProcessedSchema
     */
    private ProcessedSchema $processedSchema;

    protected function setUp(): void
    {
        $uri = new Uri('https://example.com');
        $pointer = new JsonPointer();

        $this->validator = $this->createStub(SchemaValidator::class);
        $this->identifier = new SchemaIdentifier($uri, $pointer, $pointer);
        $this->anchor = new SchemaReference($uri->withFragment('a'), $pointer->addTokens('$anchor'));
        $this->reference = new SchemaReference($uri, $pointer->addTokens('$ref'));

        $anchors = [$this->anchor];
        $references = [$this->reference];

        $this->processedSchema = new ProcessedSchema($this->validator, [$this->identifier], $anchors, $references);
    }

    public function testGetValidator(): void
    {
        $expected = $this->validator;

        $this->assertSame($expected, $this->processedSchema->getValidator());
    }

    public function testGetIdentifiers(): void
    {
        $expected = [$this->identifier];

        $this->assertSame($expected, $this->processedSchema->getIdentifiers());
    }

    public function testGetAnchors(): void
    {
        $expected = [$this->anchor];

        $this->assertSame($expected, $this->processedSchema->getAnchors());
    }

    public function testGetReferences(): void
    {
        $expected = [$this->reference];

        $this->assertSame($expected, $this->processedSchema->getReferences());
    }
}
