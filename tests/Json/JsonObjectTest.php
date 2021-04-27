<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Json;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonTrue;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\ProcessedSchema;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\UnknownKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonTrue
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\UnknownKeywordHandler
 */
final class JsonObjectTest extends TestCase
{
    /**
     * @var JsonObject
     */
    private $value;

    protected function setUp(): void
    {
        $properties = ['a' => new JsonNull(new JsonPointer('a', 'a')), 'b' => new JsonTrue(new JsonPointer('a', 'b'))];

        $this->value = new JsonObject($properties, new JsonPointer('a'));
    }

    public function testGetProperties(): void
    {
        $properties = ['a' => new JsonNull(new JsonPointer('a', 'a')), 'b' => new JsonTrue(new JsonPointer('a', 'b'))];

        $this->assertEquals($properties, $this->value->getProperties());
    }

    public function testGetPath(): void
    {
        $this->assertEquals(new JsonPointer('a'), $this->value->getPath());
    }

    /**
     * @param JsonObject|JsonNull $value
     * @param bool $expected
     *
     * @dataProvider valueProvider
     */
    public function testEquals(JsonValue $value, bool $expected): void
    {
        $this->assertEquals($expected, $this->value->equals($value));
    }

    /**
     * @return non-empty-list<array{JsonObject|JsonNull, bool}>
     */
    public function valueProvider(): array
    {
        $path = new JsonPointer('b');
        $jsonNull = new JsonNull(new JsonPointer('b', 'a'));
        $jsonTrue = new JsonTrue(new JsonPointer('b', 'b'));

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

    public function testProcessAsSchemaWithEmptyValue(): void
    {
        $path = new JsonPointer('a');

        $keyword = $this->createMock(Keyword::class);
        $keyword
            ->expects($this->never())
            ->method('process');

        $value = new JsonObject([], $path);
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $validator = new ObjectSchemaValidator([], $identifier);
        $processedSchema = new ProcessedSchema($validator, $identifier, [], [], $path);

        $this->assertEquals([$processedSchema], $value->processAsSchema($identifier, ['a' => $keyword]));
    }

    public function testProcessAsSchemaWithKnownKeyword(): void
    {
        $path = new JsonPointer('a');
        $properties = ['a' => new JsonNull($path)];

        $keyword = $this->createMock(Keyword::class);
        $keyword
            ->expects($this->once())
            ->method('process')
            ->with(
                $this->equalTo($properties),
                $this->anything(),
            );

        $value = new JsonObject($properties, $path);
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $validator = new ObjectSchemaValidator([], $identifier);
        $processedSchema = new ProcessedSchema($validator, $identifier, [], [], $path);

        $this->assertEquals([$processedSchema], $value->processAsSchema($identifier, ['a' => $keyword]));
    }

    public function testProcessAsSchemaWithUnknownKeyword(): void
    {
        $path = new JsonPointer('a');
        $properties = ['a' => new JsonNull($path)];

        $keyword = $this->createMock(Keyword::class);
        $keyword
            ->expects($this->never())
            ->method('process');

        $value = new JsonObject($properties, $path);
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $validator = new ObjectSchemaValidator([new UnknownKeywordHandler('a', $properties['a'])], $identifier);
        $processedSchema = new ProcessedSchema($validator, $identifier, [], [], $path);

        $this->assertEquals([$processedSchema], $value->processAsSchema($identifier, ['b' => $keyword]));
    }
}
