<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;

/**
 * @covers \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 */
final class SchemaIdentifierTest extends TestCase
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
     * @var SchemaIdentifier
     */
    private SchemaIdentifier $identifier;

    protected function setUp(): void
    {
        $this->uri = new Uri('https://example/com');
        $this->pointer = new JsonPointer();
        $this->identifier = new SchemaIdentifier($this->uri, $this->pointer, $this->pointer);
    }

    public function testGetUri(): void
    {
        $expected = $this->uri;

        $this->assertSame($expected, $this->identifier->getUri());
    }

    public function testGetFragment(): void
    {
        $expected = $this->pointer;

        $this->assertSame($expected, $this->identifier->getFragment());
    }

    public function testGetPath(): void
    {
        $expected = $this->pointer;

        $this->assertSame($expected, $this->identifier->getPath());
    }
}
