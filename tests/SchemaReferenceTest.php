<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaReference;

/**
 * @covers \Yakimun\JsonSchemaValidator\SchemaReference
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 */
final class SchemaReferenceTest extends TestCase
{
    /**
     * @var SchemaReference
     */
    private $reference;

    protected function setUp(): void
    {
        $this->reference = new SchemaReference(new Uri('https://example.com'), new JsonPointer('a'));
    }

    public function testGetUri(): void
    {
        $this->assertEquals(new Uri('https://example.com'), $this->reference->getUri());
    }

    public function testGetPath(): void
    {
        $this->assertEquals(new JsonPointer('a'), $this->reference->getPath());
    }
}