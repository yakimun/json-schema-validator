<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Json;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonBoolean;
use Yakimun\JsonSchemaValidator\Json\JsonFloat;
use Yakimun\JsonSchemaValidator\Json\JsonInteger;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;

/**
 * @covers \Yakimun\JsonSchemaValidator\Json\JsonInteger
 */
final class JsonIntegerTest extends TestCase
{
    /**
     * @var int
     */
    private int $value;

    /**
     * @var JsonInteger
     */
    private JsonInteger $integer;

    protected function setUp(): void
    {
        $this->value = 1;
        $this->integer = new JsonInteger($this->value);
    }

    public function testGetValue(): void
    {
        $expected = $this->value;

        $this->assertSame($expected, $this->integer->getValue());
    }

    /**
     * @param JsonValue $value
     * @param bool $expected
     * @dataProvider valueProvider
     */
    public function testEquals(JsonValue $value, bool $expected): void
    {
        $this->assertSame($expected, $this->integer->equals($value));
    }

    /**
     * @return non-empty-list<array{JsonValue, bool}>
     */
    public function valueProvider(): array
    {
        return [
            [new JsonInteger(1), true],
            [new JsonInteger(2), false],
            [new JsonNull(), false],
            [new JsonBoolean(true), false],
            [new JsonObject([]), false],
            [new JsonArray([]), false],
            [new JsonFloat(1.0), false],
            [new JsonString('a'), false],
        ];
    }
}
