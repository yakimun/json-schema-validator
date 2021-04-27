<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\CoreVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonFalse;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonTrue;
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
     * @param array<string, JsonTrue|JsonFalse> $properties
     *
     * @dataProvider valueProvider
     */
    public function testProcess(array $properties): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(['$vocabulary' => $this->keyword], $identifier);
        $expectedContext = new SchemaContext(['$vocabulary' => $this->keyword], $identifier);
        $value = new JsonObject($properties, new JsonPointer('$vocabulary'));
        $this->keyword->process(['$vocabulary' => $value], $context);

        $this->assertEquals($expectedContext, $context);
    }

    /**
     * @return non-empty-list<array{array<string, JsonTrue|JsonFalse>}>
     */
    public function valueProvider(): array
    {
        $jsonTrue = new JsonTrue(new JsonPointer('$vocabulary', 'https://example.com/foo'));
        $jsonFalse = new JsonFalse(new JsonPointer('$vocabulary', 'https://example.com/bar'));

        return [
            [[]],
            [['https://example.com/foo' => $jsonTrue]],
            [['https://example.com/bar' => $jsonFalse]],
            [['https://example.com/foo' => $jsonTrue, 'https://example.com/bar' => $jsonFalse]],
        ];
    }

    /**
     * @param JsonNull|JsonObject $value
     *
     * @dataProvider invalidValueProvider
     */
    public function testProcessWithInvalidValue(JsonValue $value): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(['$vocabulary' => $this->keyword], $identifier);

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['$vocabulary' => $value], $context);
    }

    /**
     * @return non-empty-list<array{JsonNull|JsonObject}>
     */
    public function invalidValueProvider(): array
    {
        $path = new JsonPointer('$vocabulary');
        $uri1 = 'https://example.com/foo/../bar';
        $uri2 = 'https://example.com/foo';

        return [
            [new JsonNull($path)],
            [new JsonObject(['foo' => new JsonTrue(new JsonPointer('$vocabulary', 'foo'))], $path)],
            [new JsonObject([$uri1 => new JsonTrue(new JsonPointer('$vocabulary', $uri1))], $path)],
            [new JsonObject([$uri2 => new JsonNull(new JsonPointer('$vocabulary', $uri2))], $path)],
            [new JsonObject([], new JsonPointer('foo', '$vocabulary'))],
        ];
    }
}
