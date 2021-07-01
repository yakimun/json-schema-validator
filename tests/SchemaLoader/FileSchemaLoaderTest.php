<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\SchemaLoader;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Exception\SchemaLoaderException;
use Yakimun\JsonSchemaValidator\SchemaLoader\FileSchemaLoader;
use Yakimun\JsonSchemaValidator\SchemaLoaderResult;

/**
 * @covers \Yakimun\JsonSchemaValidator\SchemaLoader\FileSchemaLoader
 * @uses \Yakimun\JsonSchemaValidator\SchemaLoaderResult
 */
final class FileSchemaLoaderTest extends TestCase
{
    /**
     * @var UriInterface
     */
    private UriInterface $uri;

    /**
     * @var string
     */
    private string $filename;

    /**
     * @var FileSchemaLoader
     */
    private FileSchemaLoader $loader;

    protected function setUp(): void
    {
        $filename = tempnam(sys_get_temp_dir(), 'jsv');

        if (!$filename) {
            throw new \RuntimeException('The file must exist and be readable.');
        }

        $fullFilename = realpath($filename);

        if (!$fullFilename) {
            throw new \RuntimeException('The file must exist and be readable.');
        }

        $this->uri = new Uri('https://example.com');
        $this->filename = $fullFilename;
        $this->loader = new FileSchemaLoader($this->uri, $this->filename);
    }

    protected function tearDown(): void
    {
        unlink($this->filename);
    }

    public function testLoad(): void
    {
        file_put_contents($this->filename, '{}');
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

    public function testLoadWithInvalidFilename(): void
    {
        $loader = new FileSchemaLoader($this->uri, '');

        $this->expectException(SchemaLoaderException::class);

        $loader->load($this->uri);
    }
}
