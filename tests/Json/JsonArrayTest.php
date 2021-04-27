<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Json;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonTrue;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

/**
 * @covers \Yakimun\JsonSchemaValidator\Json\JsonArray
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonTrue
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 */
final class JsonArrayTest extends TestCase
{
    /**
     * @var JsonArray
     */
    private $value;

    protected function setUp(): void
    {
        $items = [new JsonNull(new JsonPointer('a', '0')), new JsonTrue(new JsonPointer('a', '1'))];

        $this->value = new JsonArray($items, new JsonPointer('a'));
    }

    public function testGetItems(): void
    {
        $items = [new JsonNull(new JsonPointer('a', '0')), new JsonTrue(new JsonPointer('a', '1'))];

        $this->assertEquals($items, $this->value->getItems());
    }

    public function testGetPath(): void
    {
        $this->assertEquals(new JsonPointer('a'), $this->value->getPath());
    }

    /**
     * @param JsonArray|JsonNull $value
     * @param bool $expected
     *
     * @dataProvider valueProvider
     */
    public function testEquals(JsonValue $value, bool $expected): void
    {
        $this->assertEquals($expected, $this->value->equals($value));
    }

    /**
     * @return non-empty-list<array{JsonArray|JsonNull, bool}>
     */
    public function valueProvider(): array
    {
        $path = new JsonPointer('b');
        $jsonNull = new JsonNull(new JsonPointer('b', '0'));
        $jsonTrue = new JsonTrue(new JsonPointer('b', '1'));

        return [
            [new JsonArray([$jsonNull, $jsonTrue], $path), true],
            [new JsonArray([], $path), false],
            [new JsonArray([$jsonNull], $path), false],
            [new JsonArray([$jsonTrue, $jsonNull], $path), false],
            [new JsonArray([$jsonNull, $jsonTrue, $jsonNull], $path), false],
            [new JsonNull($path), false],
        ];
    }

    public function testProcessAsSchema(): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $keywords = ['foo' => $this->createStub(Keyword::class)];

        $this->expectException(InvalidSchemaException::class);

        /**
         * @psalm-suppress UnusedMethodCall
         */
        $this->value->processAsSchema($identifier, $keywords);
    }
}
