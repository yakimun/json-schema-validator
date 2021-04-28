<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\JsonLoader;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidValueException;
use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonFalse;
use Yakimun\JsonSchemaValidator\Json\JsonFloat;
use Yakimun\JsonSchemaValidator\Json\JsonInteger;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonTrue;
use Yakimun\JsonSchemaValidator\JsonLoader\FileJsonLoader;
use Yakimun\JsonSchemaValidator\JsonPointer;

/**
 * @covers \Yakimun\JsonSchemaValidator\JsonLoader\FileJsonLoader
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonArray
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonFalse
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonFloat
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonInteger
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonString
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonTrue
 * @uses \Yakimun\JsonSchemaValidator\JsonLoader\StringJsonLoader
 * @uses \Yakimun\JsonSchemaValidator\JsonLoader\ValueJsonLoader
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 */
final class FileJsonLoaderTest extends TestCase
{
    /**
     * @var string
     */
    private $filename;

    /**
     * @var FileJsonLoader
     */
    private $loader;

    protected function setUp(): void
    {
        $this->filename = tempnam(sys_get_temp_dir(), 'jsv');
        $this->loader = new FileJsonLoader($this->filename);
    }

    protected function tearDown(): void
    {
        unlink($this->filename);
    }

    public function testLoadFileWithNull(): void
    {
        file_put_contents($this->filename, 'null');

        $this->assertEquals(new JsonNull(new JsonPointer()), $this->loader->load());
    }

    public function testLoadTrue(): void
    {
        file_put_contents($this->filename, 'true');

        $this->assertEquals(new JsonTrue(new JsonPointer()), $this->loader->load());
    }

    public function testLoadFalse(): void
    {
        file_put_contents($this->filename, 'false');

        $this->assertEquals(new JsonFalse(new JsonPointer()), $this->loader->load());
    }

    /**
     * @param string $value
     * @param array<string, JsonNull|JsonTrue> $expected
     *
     * @dataProvider objectProvider
     */
    public function testLoadObject(string $value, array $expected): void
    {
        file_put_contents($this->filename, $value);

        $this->assertEquals(new JsonObject($expected, new JsonPointer()), $this->loader->load());
    }

    /**
     * @return non-empty-list<array{string, array<string, JsonNull|JsonTrue>}>
     */
    public function objectProvider(): array
    {
        $jsonNull = new JsonNull(new JsonPointer('a'));
        $jsonTrue = new JsonTrue(new JsonPointer('b'));

        return [
            ['{}', []],
            ['{"a": null}', ['a' => $jsonNull]],
            ['{"a": null, "b": true}', ['a' => $jsonNull, 'b' => $jsonTrue]],
        ];
    }

    /**
     * @param string $value
     * @param list<JsonNull|JsonTrue> $expected
     *
     * @dataProvider arrayProvider
     */
    public function testLoadArray(string $value, array $expected): void
    {
        file_put_contents($this->filename, $value);

        $this->assertEquals(new JsonArray($expected, new JsonPointer()), $this->loader->load());
    }

    /**
     * @return non-empty-list<array{string, list<JsonNull|JsonTrue>}>
     */
    public function arrayProvider(): array
    {
        $jsonNull = new JsonNull(new JsonPointer('0'));
        $jsonTrue = new JsonTrue(new JsonPointer('1'));

        return [
            ['[]', []],
            ['[null]', [$jsonNull]],
            ['[null, true]', [$jsonNull, $jsonTrue]],
        ];
    }

    public function testLoadInt(): void
    {
        file_put_contents($this->filename, '1');

        $this->assertEquals(new JsonInteger(1, new JsonPointer()), $this->loader->load());
    }

    public function testLoadFloat(): void
    {
        file_put_contents($this->filename, '1.5');

        $this->assertEquals(new JsonFloat(1.5, new JsonPointer()), $this->loader->load());
    }

    public function testLoadString(): void
    {
        file_put_contents($this->filename, '"a"');

        $this->assertEquals(new JsonString('a', new JsonPointer()), $this->loader->load());
    }

    public function testLoadInvalidValue(): void
    {
        $this->expectException(InvalidValueException::class);

        /**
         * @psalm-suppress UnusedMethodCall
         */
        $this->loader->load();
    }

    public function testLoadWithInvalidFilename(): void
    {
        $loader = new FileJsonLoader('');

        $this->expectException(InvalidValueException::class);

        /**
         * @psalm-suppress UnusedMethodCall
         */
        $loader->load();
    }

    public function testLoadWithInvalidFile(): void
    {
        $filename = tempnam(sys_get_temp_dir(), 'jsv');
        $loader = new FileJsonLoader($filename);
        unlink($filename);

        $this->expectException(InvalidValueException::class);

        /**
         * @psalm-suppress UnusedMethodCall
         */
        $loader->load();
    }
}
