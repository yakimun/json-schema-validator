<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Json;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidValueException;
use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonFalse;
use Yakimun\JsonSchemaValidator\Json\JsonFloat;
use Yakimun\JsonSchemaValidator\Json\JsonInteger;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonPointer;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonTrue;
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
     * @var JsonValueConverter
     */
    private $converter;

    protected function setUp(): void
    {
        $this->converter = new JsonValueConverter();
    }

    public function testConvertNull(): void
    {
        $this->assertEquals(new JsonNull(new JsonPointer()), $this->converter->convert(null));
    }

    public function testConvertTrue(): void
    {
        $this->assertEquals(new JsonTrue(new JsonPointer()), $this->converter->convert(true));
    }

    public function testConvertFalse(): void
    {
        $this->assertEquals(new JsonFalse(new JsonPointer()), $this->converter->convert(false));
    }

    /**
     * @param array<string, null|true> $properties
     * @param array<string, JsonNull|JsonTrue> $expected
     *
     * @dataProvider objectProvider
     */
    public function testConvertObject(array $properties, array $expected): void
    {
        $value = $this->converter->convert((object)$properties);

        $this->assertEquals(new JsonObject($expected, new JsonPointer()), $value);
    }

    /**
     * @return non-empty-list<array{array<string, null|true>, array<string, JsonNull|JsonTrue>}>
     */
    public function objectProvider(): array
    {
        $jsonNull = new JsonNull(new JsonPointer('a'));
        $jsonTrue = new JsonTrue(new JsonPointer('b'));

        return [
            [[], []],
            [['a' => null], ['a' => $jsonNull]],
            [['a' => null, 'b' => true], ['a' => $jsonNull, 'b' => $jsonTrue]],
        ];
    }

    /**
     * @param list<null|true> $value
     * @param list<JsonNull|JsonTrue> $expected
     *
     * @dataProvider arrayProvider
     */
    public function testConvertArray(array $value, array $expected): void
    {
        $this->assertEquals(new JsonArray($expected, new JsonPointer()), $this->converter->convert($value));
    }

    /**
     * @return non-empty-list<array{list<null|true>, list<JsonNull|JsonTrue>}>
     */
    public function arrayProvider(): array
    {
        $jsonNull = new JsonNull(new JsonPointer('0'));
        $jsonTrue = new JsonTrue(new JsonPointer('1'));

        return [
            [[], []],
            [[null], [$jsonNull]],
            [[null, true], [$jsonNull, $jsonTrue]],
        ];
    }

    /**
     * @param non-empty-list<int|string> $keys
     *
     * @dataProvider arrayWithInvalidKeysProvider
     */
    public function testConvertArrayWithInvalidKeys(array $keys): void
    {
        $this->expectException(InvalidValueException::class);

        /**
         * @psalm-suppress UnusedMethodCall
         */
        $this->converter->convert(array_flip($keys));
    }

    /**
     * @return non-empty-list<array{non-empty-list<int|string>}>
     */
    public function arrayWithInvalidKeysProvider(): array
    {
        return [
            [[1]],
            [[0, 2]],
            [['a']],
        ];
    }

    public function testConvertInt(): void
    {
        $this->assertEquals(new JsonInteger(1, new JsonPointer()), $this->converter->convert(1));
    }

    public function testConvertFloat(): void
    {
        $this->assertEquals(new JsonFloat(1.5, new JsonPointer()), $this->converter->convert(1.5));
    }

    public function testConvertString(): void
    {
        $this->assertEquals(new JsonString('foo', new JsonPointer()), $this->converter->convert('foo'));
    }

    public function testConvertInvalidValue(): void
    {
        $this->expectException(InvalidValueException::class);

        /**
         * @psalm-suppress UnusedMethodCall
         */
        $this->converter->convert(fopen('php://memory', 'rb'));
    }
}
