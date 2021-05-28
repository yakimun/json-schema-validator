<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\JsonLoader;

use GuzzleHttp\Psr7\Utils;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;
use Yakimun\JsonSchemaValidator\Exception\InvalidValueException;
use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonBoolean;
use Yakimun\JsonSchemaValidator\Json\JsonFloat;
use Yakimun\JsonSchemaValidator\Json\JsonInteger;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\JsonLoader\StreamJsonLoader;

/**
 * @covers \Yakimun\JsonSchemaValidator\JsonLoader\StreamJsonLoader
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonArray
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonBoolean
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonFloat
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonInteger
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonString
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

        $this->assertEquals(new JsonNull(), $this->loader->load());
    }

    public function testLoadBoolean(): void
    {
        $this->stream->write('true');
        $this->stream->rewind();

        $this->assertEquals(new JsonBoolean(true), $this->loader->load());
    }

    /**
     * @param string $value
     * @param array<string, JsonNull|JsonBoolean> $expected
     *
     * @dataProvider objectProvider
     */
    public function testLoadObject(string $value, array $expected): void
    {
        $this->stream->write($value);
        $this->stream->rewind();

        $this->assertEquals(new JsonObject($expected), $this->loader->load());
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
        $this->stream->write($value);
        $this->stream->rewind();

        $this->assertEquals(new JsonArray($expected), $this->loader->load());
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
        $this->stream->write('1');
        $this->stream->rewind();

        $this->assertEquals(new JsonInteger(1), $this->loader->load());
    }

    public function testLoadFloat(): void
    {
        $this->stream->write('1.5');
        $this->stream->rewind();

        $this->assertEquals(new JsonFloat(1.5), $this->loader->load());
    }

    public function testLoadString(): void
    {
        $this->stream->write('"a"');
        $this->stream->rewind();

        $this->assertEquals(new JsonString('a'), $this->loader->load());
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
