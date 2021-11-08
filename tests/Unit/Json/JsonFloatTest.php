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
 * @covers \Yakimun\JsonSchemaValidator\Json\JsonFloat
 */
final class JsonFloatTest extends TestCase
{
    /**
     * @var float
     */
    private float $value;

    /**
     * @var JsonFloat
     */
    private JsonFloat $float;

    protected function setUp(): void
    {
        $this->value = 1.0;
        $this->float = new JsonFloat($this->value);
    }

    public function testGetValue(): void
    {
        $expected = $this->value;

        $this->assertSame($expected, $this->float->getValue());
    }

    /**
     * @param JsonValue $value
     * @param bool $expected
     * @dataProvider valueProvider
     */
    public function testEquals(JsonValue $value, bool $expected): void
    {
        $this->assertSame($expected, $this->float->equals($value));
    }

    /**
     * @return non-empty-list<array{JsonValue, bool}>
     */
    public function valueProvider(): array
    {
        return [
            [new JsonFloat(1.0), true],
            [new JsonFloat(2.0), false],
            [new JsonNull(), false],
            [new JsonBoolean(true), false],
            [new JsonObject([]), false],
            [new JsonArray([]), false],
            [new JsonInteger(1), false],
            [new JsonString('a'), false],
        ];
    }
}
