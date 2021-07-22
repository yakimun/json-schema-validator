<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\SchemaLoader;

use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\Utils;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Exception\SchemaLoaderException;
use Yakimun\JsonSchemaValidator\SchemaLoader\StreamSchemaLoader;
use Yakimun\JsonSchemaValidator\SchemaLoaderResult;

/**
 * @covers \Yakimun\JsonSchemaValidator\SchemaLoader\StreamSchemaLoader
 * @uses \Yakimun\JsonSchemaValidator\SchemaLoaderResult
 */
final class StreamSchemaLoaderTest extends TestCase
{
    /**
     * @var UriInterface
     */
    private UriInterface $uri;

    /**
     * @var StreamInterface
     */
    private StreamInterface $stream;

    /**
     * @var StreamSchemaLoader
     */
    private StreamSchemaLoader $loader;

    protected function setUp(): void
    {
        $this->uri = new Uri('https://example.com');
        $this->stream = Utils::streamFor();
        $this->loader = new StreamSchemaLoader($this->uri, $this->stream);
    }

    public function testLoad(): void
    {
        $this->stream->write('{}');
        $this->stream->rewind();
        $expected = new SchemaLoaderResult((object)[]);

        $this->assertEquals($expected, $this->loader->load($this->uri));
    }

    public function testLoadWithInvalidUri(): void
    {
        $this->assertNull($this->loader->load(new Uri('https://example.org')));
    }

    public function testLoadWithInvalidJson(): void
    {
        $this->expectException(SchemaLoaderException::class);

        $this->loader->load($this->uri);
    }

    public function testLoadWithClosedStream(): void
    {
        $this->stream->close();

        $this->expectException(SchemaLoaderException::class);

        $this->loader->load($this->uri);
    }

    public function testLoadWithDetachedStream(): void
    {
        $this->stream->detach();

        $this->expectException(SchemaLoaderException::class);

        $this->loader->load($this->uri);
    }
}
