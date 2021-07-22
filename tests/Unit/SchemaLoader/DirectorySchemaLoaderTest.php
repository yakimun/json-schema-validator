<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\SchemaLoader;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Exception\SchemaLoaderException;
use Yakimun\JsonSchemaValidator\SchemaLoader\DirectorySchemaLoader;
use Yakimun\JsonSchemaValidator\SchemaLoaderResult;

/**
 * @covers \Yakimun\JsonSchemaValidator\SchemaLoader\DirectorySchemaLoader
 * @uses \Yakimun\JsonSchemaValidator\SchemaLoaderResult
 */
final class DirectorySchemaLoaderTest extends TestCase
{
    /**
     * @var UriInterface
     */
    private UriInterface $uri;

    /**
     * @var string
     */
    private string $directory;

    /**
     * @var string
     */
    private string $filename;

    /**
     * @var DirectorySchemaLoader
     */
    private DirectorySchemaLoader $loader;

    protected function setUp(): void
    {
        $uri = new Uri('https://example.com');
        $directory = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid('jsv', false);
        $filename = $directory . DIRECTORY_SEPARATOR . 'schema';

        mkdir($directory);
        touch($filename);

        $fullDirectory = realpath($directory);
        $fullFilename = realpath($filename);

        if (!$fullDirectory) {
            throw new \RuntimeException('The directory must exist and be readable.');
        }

        if (!$fullFilename) {
            throw new \RuntimeException('The file must exist and be readable.');
        }

        $this->uri = new Uri('https://example.com/schema');
        $this->directory = $fullDirectory . '/';
        $this->filename = $fullFilename;
        $this->loader = new DirectorySchemaLoader($uri, $fullDirectory);
    }

    protected function tearDown(): void
    {
        unlink($this->filename);
        rmdir($this->directory);
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

    public function testLoadWithNonExistingUri(): void
    {
        $this->assertNull($this->loader->load(new Uri('https://example.com/schema2')));
    }

    public function testLoadWithInvalidJson(): void
    {
        $this->expectException(SchemaLoaderException::class);

        $this->loader->load($this->uri);
    }
}
