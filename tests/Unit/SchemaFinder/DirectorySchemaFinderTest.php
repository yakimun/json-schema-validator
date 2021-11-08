<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\SchemaFinder;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\JsonLoader\FileJsonLoader;
use Yakimun\JsonSchemaValidator\SchemaFinder\DirectorySchemaFinder;

/**
 * @covers \Yakimun\JsonSchemaValidator\SchemaFinder\DirectorySchemaFinder
 * @uses \Yakimun\JsonSchemaValidator\JsonLoader\FileJsonLoader
 */
final class DirectorySchemaFinderTest extends TestCase
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
     * @var DirectorySchemaFinder
     */
    private DirectorySchemaFinder $finder;

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

        $this->uri = $uri->withPath('/schema');
        $this->directory = $fullDirectory . '/';
        $this->filename = $fullFilename;
        $this->finder = new DirectorySchemaFinder($uri, $fullDirectory);
    }

    protected function tearDown(): void
    {
        unlink($this->filename);
        rmdir($this->directory);
    }

    public function testFind(): void
    {
        $expected = new FileJsonLoader($this->filename);

        $this->assertEquals($expected, $this->finder->find($this->uri));
    }

    public function testFindWithInvalidUri(): void
    {
        $this->assertNull($this->finder->find(new Uri('https://example.org')));
    }

    public function testFindWithNonExistingUri(): void
    {
        $this->assertNull($this->finder->find($this->uri->withPath('/schema2')));
    }
}
