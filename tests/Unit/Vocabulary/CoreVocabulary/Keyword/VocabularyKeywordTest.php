<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\CoreVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Exception\SchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonBoolean;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaProcessor;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\VocabularyKeyword;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\VocabularyKeyword
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 */
final class VocabularyKeywordTest extends TestCase
{
    /**
     * @var UriInterface
     */
    private UriInterface $uri;

    /**
     * @var JsonPointer
     */
    private JsonPointer $pointer;

    /**
     * @var VocabularyKeyword
     */
    private VocabularyKeyword $keyword;

    /**
     * @var SchemaProcessor
     */
    private SchemaProcessor $processor;

    protected function setUp(): void
    {
        $this->uri = new Uri('https://example.com');
        $this->pointer = new JsonPointer([]);
        $this->keyword = new VocabularyKeyword();
        $this->processor = new SchemaProcessor(['$vocabulary' => $this->keyword]);
    }

    /**
     * @param array<string, JsonBoolean> $properties
     * @dataProvider valueProvider
     */
    public function testProcess(array $properties): void
    {
        $value = new JsonObject($properties);
        $identifier = new SchemaIdentifier($this->uri, $this->pointer, $this->pointer);
        $context = new SchemaContext($this->processor, ['$vocabulary' => $value], $this->pointer, $identifier, []);
        $expected = new SchemaContext($this->processor, ['$vocabulary' => $value], $this->pointer, $identifier, []);

        $this->keyword->process($value, $context);

        $this->assertEquals($expected, $context);
    }

    /**
     * @return non-empty-list<array{array<string, JsonBoolean>}>
     */
    public function valueProvider(): array
    {
        return [
            [[]],
            [['https://example.com/a' => new JsonBoolean(true)]],
            [['https://example.com/a' => new JsonBoolean(false)]],
            [['https://example.com/a' => new JsonBoolean(true), 'https://example.com/b' => new JsonBoolean(false)]],
        ];
    }

    /**
     * @param JsonValue $value
     * @param list<string> $tokens
     * @dataProvider invalidValueProvider
     */
    public function testProcessWithInvalidValue(JsonValue $value, array $tokens): void
    {
        $pointer = $this->pointer->addTokens($tokens);
        $identifier = new SchemaIdentifier($this->uri, $pointer, $pointer);
        $context = new SchemaContext($this->processor, ['$vocabulary' => $value], $pointer, $identifier, []);

        $this->expectException(SchemaException::class);

        $this->keyword->process($value, $context);
    }

    /**
     * @return non-empty-list<array{JsonValue, list<string>}>
     */
    public function invalidValueProvider(): array
    {
        return [
            [new JsonNull(), []],
            [new JsonObject(['a' => new JsonBoolean(true)]), []],
            [new JsonObject(['https://example.com/a/../b' => new JsonBoolean(true)]), []],
            [new JsonObject(['https://example.com/a' => new JsonNull()]), []],
            [new JsonObject([]), ['a']],
        ];
    }
}
