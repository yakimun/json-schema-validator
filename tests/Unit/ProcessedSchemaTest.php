<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\ProcessedSchema;
use Yakimun\JsonSchemaValidator\SchemaAnchor;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaReference;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaAnchor
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaReference
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
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
     * @var SchemaIdentifier
     */
    private SchemaIdentifier $nonCanonicalIdentifier;

    /**
     * @var SchemaAnchor
     */
    private SchemaAnchor $anchor;

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
        $uri = new Uri('https://example1.com');
        $nonCanonicalIdentifier = new Uri('https://example2.com');
        $pointer = new JsonPointer([]);

        $this->validator = new ObjectSchemaValidator(new Uri('https://example.com'), $pointer, []);
        $this->identifier = new SchemaIdentifier($uri, $pointer, $pointer);
        $this->nonCanonicalIdentifier = new SchemaIdentifier($nonCanonicalIdentifier, $pointer, $pointer);
        $this->anchor = new SchemaAnchor($uri, true, $pointer);
        $this->reference = new SchemaReference($uri, $pointer);
        $this->processedSchema = new ProcessedSchema(
            $this->validator,
            $this->identifier,
            [$this->nonCanonicalIdentifier],
            [$this->anchor],
            [$this->reference],
        );
    }

    public function testGetValidator(): void
    {
        $expected = $this->validator;

        $this->assertSame($expected, $this->processedSchema->getValidator());
    }

    public function testGetIdentifier(): void
    {
        $expected = $this->identifier;

        $this->assertSame($expected, $this->processedSchema->getIdentifier());
    }

    public function testGetNonCanonicalIdentifiers(): void
    {
        $expected = [$this->nonCanonicalIdentifier];

        $this->assertSame($expected, $this->processedSchema->getNonCanonicalIdentifiers());
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
