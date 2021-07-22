<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\SchemaLoader;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\SchemaLoader\MemorySchemaLoader;
use Yakimun\JsonSchemaValidator\SchemaLoaderResult;

/**
 * @covers \Yakimun\JsonSchemaValidator\SchemaLoader\MemorySchemaLoader
 * @uses \Yakimun\JsonSchemaValidator\SchemaLoaderResult
 */
final class MemorySchemaLoaderTest extends TestCase
{
    /**
     * @var UriInterface
     */
    private UriInterface $uri;

    /**
     * @var object
     */
    private object $schema;

    /**
     * @var MemorySchemaLoader
     */
    private MemorySchemaLoader $loader;

    protected function setUp(): void
    {
        $this->uri = new Uri('https://example.com');
        $this->schema = (object)[];
        $this->loader = new MemorySchemaLoader($this->uri, $this->schema);
    }

    public function testLoad(): void
    {
        $expected = new SchemaLoaderResult($this->schema);

        $this->assertEquals($expected, $this->loader->load($this->uri));
    }

    public function testLoadWithInvalidUri(): void
    {
        $this->assertNull($this->loader->load(new Uri('https://example.org')));
    }
}
