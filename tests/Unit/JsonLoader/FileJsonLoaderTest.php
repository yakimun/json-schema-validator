<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\JsonLoader;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\JsonLoaderException;
use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonBoolean;
use Yakimun\JsonSchemaValidator\Json\JsonFloat;
use Yakimun\JsonSchemaValidator\Json\JsonInteger;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonLoader\FileJsonLoader;

/**
 * @covers \Yakimun\JsonSchemaValidator\JsonLoader\FileJsonLoader
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonArray
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonBoolean
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonFloat
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonInteger
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonString
 * @uses \Yakimun\JsonSchemaValidator\JsonLoader\MixedJsonLoader
 * @uses \Yakimun\JsonSchemaValidator\JsonLoader\StringJsonLoader
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 */
final class FileJsonLoaderTest extends TestCase
{
    /**
     * @var string
     */
    private string $filename;

    /**
     * @var FileJsonLoader
     */
    private FileJsonLoader $loader;

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

        $this->filename = $fullFilename;
        $this->loader = new FileJsonLoader($this->filename);
    }

    protected function tearDown(): void
    {
        unlink($this->filename);
    }

    /**
     * @param string $value
     * @param JsonValue $expected
     * @dataProvider valueProvider
     */
    public function testLoad(string $value, JsonValue $expected): void
    {
        file_put_contents($this->filename, $value);

        $this->assertEquals($expected, $this->loader->load());
    }

    /**
     * @return non-empty-list<array{string, JsonValue}>
     */
    public function valueProvider(): array
    {
        return [
            ['null', new JsonNull()],
            ['true', new JsonBoolean(true)],
            ['false', new JsonBoolean(false)],
            ['{}', new JsonObject([])],
            ['{"a": null}', new JsonObject(['a' => new JsonNull()])],
            ['{"a": null, "b": true}', new JsonObject(['a' => new JsonNull(), 'b' => new JsonBoolean(true)])],
            ['[]', new JsonArray([])],
            ['[null]', new JsonArray([new JsonNull()])],
            ['1', new JsonInteger(1)],
            ['1.0', new JsonInteger(1)],
            ['1.5', new JsonFloat(1.5)],
            ['"a"', new JsonString('a')],
        ];
    }

    public function testLoadWithInvalidValue(): void
    {
        $this->expectException(JsonLoaderException::class);

        $this->loader->load();
    }

    public function testLoadWithInvalidFilename(): void
    {
        $loader = new FileJsonLoader('');

        $this->expectException(JsonLoaderException::class);

        $loader->load();
    }
}
