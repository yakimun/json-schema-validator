<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Json;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonPointer;
use Yakimun\JsonSchemaValidator\Json\JsonTrue;
use Yakimun\JsonSchemaValidator\Json\JsonValue;

/**
 * @covers \Yakimun\JsonSchemaValidator\Json\JsonArray
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonTrue
 */
final class JsonArrayTest extends TestCase
{
    /**
     * @var JsonArray
     */
    private $jsonArray;

    protected function setUp(): void
    {
        $path = new JsonPointer('a');

        $this->jsonArray = new JsonArray([new JsonNull($path), new JsonTrue($path)], $path);
    }

    public function testGetItems(): void
    {
        $items = $this->jsonArray->getItems();

        $this->assertCount(2, $items);
        $this->assertInstanceOf(JsonNull::class, $items[0]);
        $this->assertInstanceOf(JsonTrue::class, $items[1]);
    }

    public function testGetPath(): void
    {
        $this->assertEquals('/a', $this->jsonArray->getPath());
    }

    /**
     * @param JsonValue $value
     * @param bool $expected
     *
     * @dataProvider valueProvider
     */
    public function testEquals(JsonValue $value, bool $expected): void
    {
        $this->assertEquals($expected, $this->jsonArray->equals($value));
    }

    /**
     * @return list<array{JsonValue, bool}>
     */
    public function valueProvider(): array
    {
        $path = new JsonPointer('b');

        $jsonNull = new JsonNull($path);
        $jsonTrue = new JsonTrue($path);

        return [
            [new JsonArray([$jsonNull, $jsonTrue], $path), true],
            [new JsonArray([], $path), false],
            [new JsonArray([$jsonNull], $path), false],
            [new JsonArray([$jsonTrue, $jsonNull], $path), false],
            [new JsonArray([$jsonNull, $jsonTrue, $jsonNull], $path), false],
            [new JsonNull($path), false],
        ];
    }
}
