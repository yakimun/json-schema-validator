<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaAnchor;

/**
 * @covers \Yakimun\JsonSchemaValidator\SchemaAnchor
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 */
final class SchemaAnchorTest extends TestCase
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
     * @var SchemaAnchor
     */
    private SchemaAnchor $anchor;

    protected function setUp(): void
    {
        $this->uri = new Uri('https://example/com');
        $this->pointer = new JsonPointer('a');
        $this->anchor = new SchemaAnchor($this->uri, true, $this->pointer);
    }

    public function testGetUri(): void
    {
        $expected = $this->uri;

        $this->assertEquals($expected, $this->anchor->getUri());
    }

    public function testIsDynamic(): void
    {
        $this->assertTrue($this->anchor->isDynamic());
    }

    public function testGetPath(): void
    {
        $expected = $this->pointer;

        $this->assertEquals($expected, $this->anchor->getPath());
    }
}
