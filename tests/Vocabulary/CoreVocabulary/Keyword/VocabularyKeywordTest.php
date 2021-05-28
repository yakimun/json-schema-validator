<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\CoreVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonBoolean;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\VocabularyKeyword;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\VocabularyKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 */
final class VocabularyKeywordTest extends TestCase
{
    /**
     * @var VocabularyKeyword
     */
    private $keyword;

    protected function setUp(): void
    {
        $this->keyword = new VocabularyKeyword();
    }

    public function testGetName(): void
    {
        $this->assertEquals('$vocabulary', $this->keyword->getName());
    }

    /**
     * @param array<string, JsonBoolean|JsonBoolean> $properties
     *
     * @dataProvider valueProvider
     */
    public function testProcess(array $properties): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['$vocabulary' => $this->keyword], $identifier);
        $expectedContext = new SchemaContext(['$vocabulary' => $this->keyword], $identifier);
        $this->keyword->process(['$vocabulary' => new JsonObject($properties)], $pointer, $context);

        $this->assertEquals($expectedContext, $context);
    }

    /**
     * @return non-empty-list<array{array<string, JsonBoolean>}>
     */
    public function valueProvider(): array
    {
        $jsonBoolean1 = new JsonBoolean(true);
        $jsonBoolean2 = new JsonBoolean(false);

        return [
            [[]],
            [['https://example.com/foo' => $jsonBoolean1]],
            [['https://example.com/bar' => $jsonBoolean2]],
            [['https://example.com/foo' => $jsonBoolean1, 'https://example.com/bar' => $jsonBoolean2]],
        ];
    }

    /**
     * @param JsonNull|JsonObject $value
     * @param JsonPointer $pointer
     *
     * @dataProvider invalidValueProvider
     */
    public function testProcessWithInvalidValue(JsonValue $value, JsonPointer $pointer): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['$vocabulary' => $this->keyword], $identifier);

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['$vocabulary' => $value], $pointer, $context);
    }

    /**
     * @return non-empty-list<array{JsonNull|JsonObject, JsonPointer}>
     */
    public function invalidValueProvider(): array
    {
        $pointer = new JsonPointer();
        $uri1 = 'https://example.com/foo/../bar';
        $uri2 = 'https://example.com/foo';

        return [
            [new JsonNull(), $pointer],
            [new JsonObject(['foo' => new JsonBoolean(true)]), $pointer],
            [new JsonObject([$uri1 => new JsonBoolean(true)]), $pointer],
            [new JsonObject([$uri2 => new JsonNull()]), $pointer],
            [new JsonObject([]), new JsonPointer('foo')],
        ];
    }
}
