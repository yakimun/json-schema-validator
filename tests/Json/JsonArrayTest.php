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
        $jsonPointer = new JsonPointer();
        $path = $jsonPointer->addToken('a');
        $items = [new JsonNull($path->addToken('0')), new JsonTrue($path->addToken('1'))];

        $this->jsonArray = new JsonArray($items, $path);
    }

    public function testGetItems(): void
    {
        $jsonPointer = new JsonPointer();
        $path = $jsonPointer->addToken('a');
        $items = [new JsonNull($path->addToken('0')), new JsonTrue($path->addToken('1'))];

        $this->assertEquals($items, $this->jsonArray->getItems());
    }

    public function testGetPath(): void
    {
        $jsonPointer = new JsonPointer();

        $this->assertEquals($jsonPointer->addToken('a'), $this->jsonArray->getPath());
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
     * @return non-empty-list<array{JsonValue, bool}>
     */
    public function valueProvider(): array
    {
        $jsonPointer = new JsonPointer();
        $path = $jsonPointer->addToken('b');
        $jsonNull = new JsonNull($path->addToken('0'));
        $jsonTrue = new JsonTrue($path->addToken('1'));

        return [
            [new JsonArray([new JsonNull($path), $jsonTrue], $path), true],
            [new JsonArray([], $path), false],
            [new JsonArray([$jsonNull], $path), false],
            [new JsonArray([$jsonTrue, $jsonNull], $path), false],
            [new JsonArray([$jsonNull, $jsonTrue, $jsonNull], $path), false],
            [new JsonNull($path), false],
        ];
    }
}
