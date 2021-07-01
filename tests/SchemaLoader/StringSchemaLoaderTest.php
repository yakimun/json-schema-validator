<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\SchemaLoader;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Exception\SchemaLoaderException;
use Yakimun\JsonSchemaValidator\SchemaLoader\StringSchemaLoader;
use Yakimun\JsonSchemaValidator\SchemaLoaderResult;

/**
 * @covers \Yakimun\JsonSchemaValidator\SchemaLoader\StringSchemaLoader
 * @uses \Yakimun\JsonSchemaValidator\SchemaLoaderResult
 */
final class StringSchemaLoaderTest extends TestCase
{
    /**
     * @var UriInterface
     */
    private UriInterface $uri;

    /**
     * @var StringSchemaLoader
     */
    private StringSchemaLoader $loader;

    protected function setUp(): void
    {
        $this->uri = new Uri('https://example.com');

        $json = '{}';

        $this->loader = new StringSchemaLoader($this->uri, $json);
    }

    public function testLoad(): void
    {
        $expected = new SchemaLoaderResult((object)[]);

        $this->assertEquals($expected, $this->loader->load($this->uri));
    }

    public function testLoadWithInvalidUri(): void
    {
        $this->assertNull($this->loader->load(new Uri('https://example.org')));
    }

    public function testLoadWithInvalidJson(): void
    {
        $loader = new StringSchemaLoader($this->uri, '');

        $this->expectException(SchemaLoaderException::class);

        /**
         * @psalm-suppress UnusedMethodCall
         */
        $loader->load($this->uri);
    }
}
