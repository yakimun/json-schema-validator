<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\SchemaFinder;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\JsonLoader\FileJsonLoader;
use Yakimun\JsonSchemaValidator\SchemaFinder\DirectorySchemaFinder;

/**
 * @covers \Yakimun\JsonSchemaValidator\SchemaFinder\DirectorySchemaFinder
 * @uses \Yakimun\JsonSchemaValidator\JsonLoader\FileJsonLoader
 */
final class DirectorySchemaFinderTest extends TestCase
{
    /**
     * @var string
     */
    private $directory;

    /**
     * @var string
     */
    private $filename;

    /**
     * @var DirectorySchemaFinder
     */
    private $finder;

    protected function setUp(): void
    {
        $directory = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid('jsv', false) . DIRECTORY_SEPARATOR;

        if (!mkdir($directory)) {
            throw new \RuntimeException('Temporary directory cannot be created');
        }

        $filename = $directory . 'schema';

        if (!touch($filename)) {
            throw new \RuntimeException('Temporary file cannot be created');
        }

        $filename = realpath($filename);

        if (!$filename) {
            throw new \RuntimeException('Temporary file not found');
        }

        $this->directory = $directory;
        $this->filename = $filename;
        $this->finder = new DirectorySchemaFinder(new Uri('https://example.com/'), $directory);
    }

    protected function tearDown(): void
    {
        unlink($this->filename);
        rmdir($this->directory);
    }

    public function testLoad(): void
    {
        $loader = new FileJsonLoader($this->filename);

        $this->assertEquals($loader, $this->finder->find(new Uri('https://example.com/schema')));
    }

    public function testLoadWithInvalidUri(): void
    {
        $this->assertNull($this->finder->find(new Uri('https://example.com/schema2')));
    }
}
