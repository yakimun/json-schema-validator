<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\SchemaLoader;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\SchemaLoader\CachingSchemaLoader;
use Yakimun\JsonSchemaValidator\SchemaLoader\SchemaLoader;
use Yakimun\JsonSchemaValidator\SchemaLoaderResult;

/**
 * @covers \Yakimun\JsonSchemaValidator\SchemaLoader\CachingSchemaLoader
 * @uses \Yakimun\JsonSchemaValidator\SchemaLoaderResult
 */
final class CachingSchemaLoaderTest extends TestCase
{
    /**
     * @var UriInterface
     */
    private UriInterface $uri;

    /**
     * @var UriInterface
     */
    private UriInterface $invalidUri;

    /**
     * @var CachingSchemaLoader
     */
    private CachingSchemaLoader $loader;

    /**
     * @var SchemaLoader&MockObject
     */
    private SchemaLoader $internalLoader;

    protected function setUp(): void
    {
        $this->uri = new Uri('https://example.com');
        $this->invalidUri = new Uri('https://example.org');
        $this->internalLoader = $this->createMock(SchemaLoader::class);
        $this->loader = new CachingSchemaLoader($this->internalLoader);
    }

    public function testLoad(): void
    {
        $expected = new SchemaLoaderResult(null);

        $this->internalLoader
            ->expects($this->once())
            ->method('load')
            ->with($this->uri)
            ->willReturn($expected);

        $this->assertEquals($expected, $this->loader->load($this->uri));
        $this->assertEquals($expected, $this->loader->load($this->uri));
    }

    public function testLoadWithInvalidUri(): void
    {
        $this->internalLoader
            ->expects($this->once())
            ->method('load')
            ->with($this->invalidUri);

        $this->assertNull($this->loader->load($this->invalidUri));
    }
}
