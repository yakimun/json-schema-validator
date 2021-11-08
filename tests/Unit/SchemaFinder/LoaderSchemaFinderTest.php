<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\SchemaFinder;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\JsonLoader\JsonLoader;
use Yakimun\JsonSchemaValidator\JsonLoader\MemoryJsonLoader;
use Yakimun\JsonSchemaValidator\SchemaFinder\LoaderSchemaFinder;

/**
 * @covers \Yakimun\JsonSchemaValidator\SchemaFinder\LoaderSchemaFinder
 * @uses \Yakimun\JsonSchemaValidator\JsonLoader\MemoryJsonLoader
 */
final class LoaderSchemaFinderTest extends TestCase
{
    /**
     * @var UriInterface
     */
    private UriInterface $uri;

    /**
     * @var JsonLoader
     */
    private JsonLoader $loader;

    /**
     * @var LoaderSchemaFinder
     */
    private LoaderSchemaFinder $finder;

    protected function setUp(): void
    {
        $this->uri = new Uri('https://example.com');
        $this->loader = new MemoryJsonLoader(new JsonNull());
        $this->finder = new LoaderSchemaFinder($this->uri, $this->loader);
    }

    public function testFind(): void
    {
        $expected = $this->loader;

        $this->assertSame($expected, $this->finder->find($this->uri));
    }

    public function testFindWithInvalidUri(): void
    {
        $this->assertNull($this->finder->find(new Uri('https://example.org')));
    }
}
