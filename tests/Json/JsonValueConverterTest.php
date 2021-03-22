<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Json;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonFalse;
use Yakimun\JsonSchemaValidator\Json\JsonFloat;
use Yakimun\JsonSchemaValidator\Json\JsonInteger;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonPointer;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonTrue;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\Json\JsonValueConverter;

/**
 * @covers \Yakimun\JsonSchemaValidator\Json\JsonValueConverter
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonArray
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonFalse
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonFloat
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonInteger
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonString
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonTrue
 */
final class JsonValueConverterTest extends TestCase
{
    /**
     * @param null|scalar|object|list<mixed> $value
     * @param JsonValue $expected
     *
     * @dataProvider valueProvider
     */
    public function testConvert($value, JsonValue $expected): void
    {
        $jsonValueConverter = new JsonValueConverter();

        $this->assertEquals($expected, $jsonValueConverter->convert($value));
    }

    /**
     * @return list<array{null|scalar|object|list<mixed>, JsonValue}>
     */
    public function valueProvider(): array
    {
        $path = new JsonPointer();

        return [
            [null, new JsonNull($path)],
            [true, new JsonTrue($path)],
            [false, new JsonFalse($path)],
            [(object)['a' => null], new JsonObject(['a' => new JsonNull($path->addToken('a'))], $path)],
            [[null], new JsonArray([new JsonNull($path->addToken('0'))], $path)],
            [1, new JsonInteger(1, $path)],
            [1.5, new JsonFloat(1.5, $path)],
            ['foo', new JsonString('foo', $path)],
        ];
    }
}
