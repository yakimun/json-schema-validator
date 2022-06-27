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
use Yakimun\JsonSchemaValidator\JsonLoader\MixedJsonLoader;

/**
 * @covers \Yakimun\JsonSchemaValidator\JsonLoader\MixedJsonLoader
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonArray
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonBoolean
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonFloat
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonInteger
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonString
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 */
final class MixedJsonLoaderTest extends TestCase
{
    /**
     * @param list<mixed>|null|object|scalar $value
     * @param JsonValue $expected
     * @dataProvider valueProvider
     */
    public function testLoad($value, JsonValue $expected): void
    {
        $loader = new MixedJsonLoader($value);

        $this->assertEquals($expected, $loader->load());
    }

    /**
     * @return non-empty-list<array{list<mixed>|null|object|scalar, JsonValue}>
     */
    public function valueProvider(): array
    {
        return [
            [null, new JsonNull()],
            [true, new JsonBoolean(true)],
            [false, new JsonBoolean(false)],
            [(object)[], new JsonObject([])],
            [(object)['a' => null], new JsonObject(['a' => new JsonNull()])],
            [(object)['a' => null, 'b' => true], new JsonObject(['a' => new JsonNull(), 'b' => new JsonBoolean(true)])],
            [[], new JsonArray([])],
            [[null], new JsonArray([new JsonNull()])],
            [1, new JsonInteger(1)],
            [1.0, new JsonInteger(1)],
            [1.5, new JsonFloat(1.5)],
            ['a', new JsonString('a')],
        ];
    }

    public function testLoadWithInvalidValue(): void
    {
        $loader = new MixedJsonLoader([fopen('php://memory', 'rb')]);

        $this->expectException(JsonLoaderException::class);

        $loader->load();
    }
}
