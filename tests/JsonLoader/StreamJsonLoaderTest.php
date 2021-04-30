<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\JsonLoader;

use GuzzleHttp\Psr7\Utils;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;
use Yakimun\JsonSchemaValidator\Exception\InvalidValueException;
use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonFalse;
use Yakimun\JsonSchemaValidator\Json\JsonFloat;
use Yakimun\JsonSchemaValidator\Json\JsonInteger;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonTrue;
use Yakimun\JsonSchemaValidator\JsonLoader\StreamJsonLoader;
use Yakimun\JsonSchemaValidator\JsonPointer;

/**
 * @covers \Yakimun\JsonSchemaValidator\JsonLoader\StreamJsonLoader
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
final class StreamJsonLoaderTest extends TestCase
{
    /**
     * @var StreamInterface
     */
    private $stream;

    /**
     * @var StreamJsonLoader
     */
    private $loader;

    protected function setUp(): void
    {
        $this->stream = Utils::streamFor();
        $this->loader = new StreamJsonLoader($this->stream);
    }

    public function testLoadFileWithNull(): void
    {
        $this->stream->write('null');
        $this->stream->rewind();

        $this->assertEquals(new JsonNull(new JsonPointer()), $this->loader->load());
    }

    public function testLoadTrue(): void
    {
        $this->stream->write('true');
        $this->stream->rewind();

        $this->assertEquals(new JsonTrue(new JsonPointer()), $this->loader->load());
    }

    public function testLoadFalse(): void
    {
        $this->stream->write('false');
        $this->stream->rewind();

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
        $this->stream->write($value);
        $this->stream->rewind();

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
        $this->stream->write($value);
        $this->stream->rewind();

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
        $this->stream->write('1');
        $this->stream->rewind();

        $this->assertEquals(new JsonInteger(1, new JsonPointer()), $this->loader->load());
    }

    public function testLoadFloat(): void
    {
        $this->stream->write('1.5');
        $this->stream->rewind();

        $this->assertEquals(new JsonFloat(1.5, new JsonPointer()), $this->loader->load());
    }

    public function testLoadString(): void
    {
        $this->stream->write('"a"');
        $this->stream->rewind();

        $this->assertEquals(new JsonString('a', new JsonPointer()), $this->loader->load());
    }

    public function testLoadInvalidValue(): void
    {
        $this->expectException(InvalidValueException::class);

        $this->loader->load();
    }

    public function testLoadWithClosedStream(): void
    {
        $this->stream->close();

        $this->expectException(InvalidValueException::class);

        $this->loader->load();
    }

    public function testLoadWithDetachedStream(): void
    {
        $this->stream->detach();

        $this->expectException(InvalidValueException::class);

        $this->loader->load();
    }
}
