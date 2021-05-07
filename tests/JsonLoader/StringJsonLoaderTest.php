<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\JsonLoader;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidValueException;
use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonBoolean;
use Yakimun\JsonSchemaValidator\Json\JsonFloat;
use Yakimun\JsonSchemaValidator\Json\JsonInteger;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\JsonLoader\StringJsonLoader;
use Yakimun\JsonSchemaValidator\JsonPointer;

/**
 * @covers \Yakimun\JsonSchemaValidator\JsonLoader\StringJsonLoader
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonArray
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonBoolean
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonFloat
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonInteger
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonString
 * @uses \Yakimun\JsonSchemaValidator\JsonLoader\ValueJsonLoader
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 */
final class StringJsonLoaderTest extends TestCase
{
    public function testLoadStringWithNull(): void
    {
        $loader = new StringJsonLoader('null');

        $this->assertEquals(new JsonNull(new JsonPointer()), $loader->load());
    }

    public function testLoadBoolean(): void
    {
        $loader = new StringJsonLoader('true');

        $this->assertEquals(new JsonBoolean(true, new JsonPointer()), $loader->load());
    }

    /**
     * @param string $value
     * @param array<string, JsonNull|JsonBoolean> $expected
     *
     * @dataProvider objectProvider
     */
    public function testLoadObject(string $value, array $expected): void
    {
        $loader = new StringJsonLoader($value);

        $this->assertEquals(new JsonObject($expected, new JsonPointer()), $loader->load());
    }

    /**
     * @return non-empty-list<array{string, array<string, JsonNull|JsonBoolean>}>
     */
    public function objectProvider(): array
    {
        $jsonNull = new JsonNull(new JsonPointer('a'));
        $jsonBoolean = new JsonBoolean(true, new JsonPointer('b'));

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
        $loader = new StringJsonLoader($value);

        $this->assertEquals(new JsonArray($expected, new JsonPointer()), $loader->load());
    }

    /**
     * @return non-empty-list<array{string, list<JsonNull|JsonBoolean>}>
     */
    public function arrayProvider(): array
    {
        $jsonNull = new JsonNull(new JsonPointer('0'));
        $jsonBoolean = new JsonBoolean(true, new JsonPointer('1'));

        return [
            ['[]', []],
            ['[null]', [$jsonNull]],
            ['[null, true]', [$jsonNull, $jsonBoolean]],
        ];
    }

    public function testLoadInt(): void
    {
        $loader = new StringJsonLoader('1');

        $this->assertEquals(new JsonInteger(1, new JsonPointer()), $loader->load());
    }

    public function testLoadFloat(): void
    {
        $loader = new StringJsonLoader('1.5');

        $this->assertEquals(new JsonFloat(1.5, new JsonPointer()), $loader->load());
    }

    public function testLoadString(): void
    {
        $loader = new StringJsonLoader('"a"');

        $this->assertEquals(new JsonString('a', new JsonPointer()), $loader->load());
    }

    public function testLoadInvalidValue(): void
    {
        $loader = new StringJsonLoader('');

        $this->expectException(InvalidValueException::class);

        /**
         * @psalm-suppress UnusedMethodCall
         */
        $loader->load();
    }
}
