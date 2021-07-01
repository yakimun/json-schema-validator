<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests;

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
        $this->pointer = new JsonPointer('a');
        $this->identifier = new SchemaIdentifier($this->uri, $this->pointer, $this->pointer);
    }

    public function testGetUri(): void
    {
        $expected = $this->uri;

        $this->assertEquals($expected, $this->identifier->getUri());
    }

    public function testGetFragment(): void
    {
        $expected = $this->pointer;

        $this->assertEquals($expected, $this->identifier->getFragment());
    }

    public function testGetPath(): void
    {
        $expected = $this->pointer;

        $this->assertEquals($expected, $this->identifier->getPath());
    }
}
