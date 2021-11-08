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
use Yakimun\JsonSchemaValidator\JsonLoader\StringJsonLoader;

/**
 * @covers \Yakimun\JsonSchemaValidator\JsonLoader\StringJsonLoader
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonArray
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonBoolean
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonFloat
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonInteger
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonString
 * @uses \Yakimun\JsonSchemaValidator\JsonLoader\MixedJsonLoader
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 */
final class StringJsonLoaderTest extends TestCase
{
    /**
     * @param string $value
     * @param JsonValue $expected
     * @dataProvider valueProvider
     */
    public function testLoad(string $value, JsonValue $expected): void
    {
        $loader = new StringJsonLoader($value);

        $this->assertEquals($expected, $loader->load());
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
            ['1.0', new JsonFloat(1.0)],
            ['"a"', new JsonString('a')],
        ];
    }

    public function testLoadWithInvalidValue(): void
    {
        $loader = new StringJsonLoader('a');

        $this->expectException(JsonLoaderException::class);

        $loader->load();
    }
}
