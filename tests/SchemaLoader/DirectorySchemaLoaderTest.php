<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\SchemaLoader;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidValueException;
use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonBoolean;
use Yakimun\JsonSchemaValidator\Json\JsonFloat;
use Yakimun\JsonSchemaValidator\Json\JsonInteger;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\SchemaLoader\DirectorySchemaLoader;

/**
 * @covers \Yakimun\JsonSchemaValidator\SchemaLoader\DirectorySchemaLoader
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonArray
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonBoolean
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonFloat
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonInteger
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonString
 * @uses \Yakimun\JsonSchemaValidator\JsonLoader\FileJsonLoader
 * @uses \Yakimun\JsonSchemaValidator\JsonLoader\StreamJsonLoader
 * @uses \Yakimun\JsonSchemaValidator\JsonLoader\StringJsonLoader
 * @uses \Yakimun\JsonSchemaValidator\JsonLoader\ValueJsonLoader
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 */
final class DirectorySchemaLoaderTest extends TestCase
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
     * @var DirectorySchemaLoader
     */
    private $loader;

    protected function setUp(): void
    {
        $directory = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid('jsv', false) . DIRECTORY_SEPARATOR;

        if (!mkdir($directory)) {
            throw new \RuntimeException('The temporary directory cannot be created.');
        }

        $filename = $directory . 'schema';

        if (!touch($filename)) {
            throw new \RuntimeException('The temporary file cannot be created.');
        }

        $this->directory = $directory;
        $this->filename = $filename;
        $this->loader = new DirectorySchemaLoader(new Uri('https://example.com/'), $directory);
    }

    protected function tearDown(): void
    {
        unlink($this->filename);
        rmdir($this->directory);
    }

    public function testLoadNull(): void
    {
        file_put_contents($this->filename, 'null');

        $this->assertEquals(new JsonNull(), $this->loader->load(new Uri('https://example.com/schema')));
    }

    public function testLoadBoolean(): void
    {
        file_put_contents($this->filename, 'true');

        $this->assertEquals(new JsonBoolean(true), $this->loader->load(new Uri('https://example.com/schema')));
    }

    /**
     * @param string $value
     * @param array<string, JsonNull|JsonBoolean> $expected
     *
     * @dataProvider objectProvider
     */
    public function testLoadObject(string $value, array $expected): void
    {
        file_put_contents($this->filename, $value);

        $this->assertEquals(new JsonObject($expected), $this->loader->load(new Uri('https://example.com/schema')));
    }

    /**
     * @return non-empty-list<array{string, array<string, JsonNull|JsonBoolean>}>
     */
    public function objectProvider(): array
    {
        $jsonNull = new JsonNull();
        $jsonBoolean = new JsonBoolean(true);

        return [
            ['{}', []],
            ['{"a": null}', ['a' => $jsonNull]],
            ['{"a": null, "b": true}', ['a' => $jsonNull, 'b' => $jsonBoolean]],
        ];
    }

    /**
     * @param string $value
     * @param list<JsonNull|JsonBoolean> $expected
     *
     * @dataProvider arrayProvider
     */
    public function testLoadArray(string $value, array $expected): void
    {
        file_put_contents($this->filename, $value);

        $this->assertEquals(new JsonArray($expected), $this->loader->load(new Uri('https://example.com/schema')));
    }

    /**
     * @return non-empty-list<array{string, list<JsonNull|JsonBoolean>}>
     */
    public function arrayProvider(): array
    {
        $jsonNull = new JsonNull();
        $jsonBoolean = new JsonBoolean(true);

        return [
            ['[]', []],
            ['[null]', [$jsonNull]],
            ['[null, true]', [$jsonNull, $jsonBoolean]],
        ];
    }

    public function testLoadInt(): void
    {
        file_put_contents($this->filename, '1');

        $this->assertEquals(new JsonInteger(1), $this->loader->load(new Uri('https://example.com/schema')));
    }

    public function testLoadFloat(): void
    {
        file_put_contents($this->filename, '1.5');

        $this->assertEquals(new JsonFloat(1.5), $this->loader->load(new Uri('https://example.com/schema')));
    }

    public function testLoadString(): void
    {
        file_put_contents($this->filename, '"a"');

        $this->assertEquals(new JsonString('a'), $this->loader->load(new Uri('https://example.com/schema')));
    }

    public function testLoadInvalidValue(): void
    {
        $this->expectException(InvalidValueException::class);

        $this->loader->load(new Uri('https://example.com/schema'));
    }

    public function testLoadWithInvalidUri(): void
    {
        $this->assertNull($this->loader->load(new Uri('https://example.com/schema2')));
    }
}
