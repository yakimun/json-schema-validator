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
    private $jsonValueConverter;

    protected function setUp(): void
    {
        $this->jsonValueConverter = new JsonValueConverter();
    }

    public function testConvertNull(): void
    {
        $jsonValue = $this->jsonValueConverter->convert(null);
        $this->assertEquals(new JsonNull(new JsonPointer()), $jsonValue);
    }

    public function testConvertTrue(): void
    {
        $jsonValue = $this->jsonValueConverter->convert(true);
        $this->assertEquals(new JsonTrue(new JsonPointer()), $jsonValue);
    }

    public function testConvertFalse(): void
    {
        $jsonValue = $this->jsonValueConverter->convert(false);
        $this->assertEquals(new JsonFalse(new JsonPointer()), $jsonValue);
    }

    /**
     * @param array<string, null|true> $valueProperties
     * @param array<string, JsonNull|JsonTrue> $expectedProperties
     *
     * @dataProvider objectProvider
     */
    public function testConvertObject(array $valueProperties, array $expectedProperties): void
    {
        $jsonValue = $this->jsonValueConverter->convert((object)$valueProperties);
        $this->assertEquals(new JsonObject($expectedProperties, new JsonPointer()), $jsonValue);
    }

    /**
     * @return list<array{array<string, null|true>, array<string, JsonNull|JsonTrue>}>
     */
    public function objectProvider(): array
    {
        $jsonPointer = new JsonPointer();

        $jsonNull = new JsonNull($jsonPointer->addToken('a'));
        $jsonTrue = new JsonTrue($jsonPointer->addToken('b'));

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
        $jsonValue = $this->jsonValueConverter->convert($value);
        $this->assertEquals(new JsonArray($expected, new JsonPointer()), $jsonValue);
    }

    /**
     * @return list<array{list<null|true>, list<JsonNull|JsonTrue>}>
     */
    public function arrayProvider(): array
    {
        $jsonPointer = new JsonPointer();

        $jsonNull = new JsonNull($jsonPointer->addToken('0'));
        $jsonTrue = new JsonTrue($jsonPointer->addToken('1'));

        return [
            [[], []],
            [[null], [$jsonNull]],
            [[null, true], [$jsonNull, $jsonTrue]],
        ];
    }

    /**
     * @param array<array-key, null> $value
     *
     * @dataProvider arrayWithInvalidKeysProvider
     */
    public function testConvertArrayWithInvalidKeys(array $value): void
    {
        $this->expectException(InvalidValueException::class);
        $this->jsonValueConverter->convert($value);
    }

    /**
     * @return list<list<array<array-key, null>>>
     */
    public function arrayWithInvalidKeysProvider(): array
    {
        return [
            [['a' => null]],
            [[1 => null]],
            [[0 => null, 2 => null]],
        ];
    }

    public function testConvertInt(): void
    {
        $jsonValue = $this->jsonValueConverter->convert(1);
        $this->assertEquals(new JsonInteger(1, new JsonPointer()), $jsonValue);
    }

    public function testConvertFloat(): void
    {
        $jsonValue = $this->jsonValueConverter->convert(1.0);
        $this->assertEquals(new JsonFloat(1.0, new JsonPointer()), $jsonValue);
    }

    public function testConvertString(): void
    {
        $jsonValue = $this->jsonValueConverter->convert('foo');
        $this->assertEquals(new JsonString('foo', new JsonPointer()), $jsonValue);
    }

    public function testConvertInvalidValue(): void
    {
        $this->expectException(InvalidValueException::class);
        $this->jsonValueConverter->convert(fopen('php://memory', 'rb'));
    }
}
