<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaReference;

/**
 * @covers \Yakimun\JsonSchemaValidator\SchemaReference
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 */
final class SchemaReferenceTest extends TestCase
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
     * @var SchemaReference
     */
    private SchemaReference $reference;

    protected function setUp(): void
    {
        $this->uri = new Uri('https://example/com');
        $this->pointer = new JsonPointer([]);
        $this->reference = new SchemaReference($this->uri, $this->pointer);
    }

    public function testGetUri(): void
    {
        $expected = $this->uri;

        $this->assertSame($expected, $this->reference->getUri());
    }

    public function testGetPath(): void
    {
        $expected = $this->pointer;

        $this->assertSame($expected, $this->reference->getPath());
    }
}
