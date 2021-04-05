<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Json;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonPointer;
use Yakimun\JsonSchemaValidator\Json\JsonTrue;
use Yakimun\JsonSchemaValidator\Json\JsonValue;

/**
 * @covers \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonTrue
 */
final class JsonObjectTest extends TestCase
{
    /**
     * @var JsonObject
     */
    private $jsonObject;

    protected function setUp(): void
    {
        $jsonPointer = new JsonPointer();
        $path = $jsonPointer->addToken('a');
        $properties = ['a' => new JsonNull($path->addToken('a')), 'b' => new JsonTrue($path->addToken('b'))];

        $this->jsonObject = new JsonObject($properties, $path);
    }

    public function testGetProperties(): void
    {
        $jsonPointer = new JsonPointer();
        $path = $jsonPointer->addToken('a');
        $properties = ['a' => new JsonNull($path->addToken('a')), 'b' => new JsonTrue($path->addToken('b'))];

        $this->assertEquals($properties, $this->jsonObject->getProperties());
    }

    public function testGetPath(): void
    {
        $jsonPointer = new JsonPointer();

        $this->assertEquals($jsonPointer->addToken('a'), $this->jsonObject->getPath());
    }

    /**
     * @param JsonValue $value
     * @param bool $expected
     *
     * @dataProvider valueProvider
     */
    public function testEquals(JsonValue $value, bool $expected): void
    {
        $this->assertEquals($expected, $this->jsonObject->equals($value));
    }

    /**
     * @return non-empty-list<array{JsonValue, bool}>
     */
    public function valueProvider(): array
    {
        $jsonPointer = new JsonPointer();
        $path = $jsonPointer->addToken('b');
        $jsonNull = new JsonNull($path->addToken('a'));
        $jsonTrue = new JsonTrue($path->addToken('b'));

        return [
            [new JsonObject(['a' => $jsonNull, 'b' => $jsonTrue], $path), true],
            [new JsonObject(['b' => $jsonTrue, 'a' => $jsonNull], $path), true],
            [new JsonObject([], $path), false],
            [new JsonObject(['a' => $jsonNull], $path), false],
            [new JsonObject(['a' => $jsonTrue, 'b' => $jsonNull], $path), false],
            [new JsonObject(['a' => $jsonNull, 'b' => $jsonTrue, 'c' => $jsonNull], $path), false],
            [new JsonNull($path), false],
        ];
    }
}
