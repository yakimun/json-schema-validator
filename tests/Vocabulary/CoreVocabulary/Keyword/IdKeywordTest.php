<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\CoreVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\IdKeyword;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\IdKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonString
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 */
final class IdKeywordTest extends TestCase
{
    /**
     * @var IdKeyword
     */
    private $keyword;

    protected function setUp(): void
    {
        $this->keyword = new IdKeyword();
    }

    public function testGetName(): void
    {
        $this->assertEquals('$id', $this->keyword->getName());
    }

    /**
     * @param string $value
     * @param string $expected
     *
     * @dataProvider valueProvider
     */
    public function testProcess(string $value, string $expected): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com/a/b'), $pointer);
        $context = new SchemaContext(['$id' => $this->keyword], $identifier);
        $this->keyword->process(['$id' => new JsonString($value)], $pointer, $context);

        $this->assertEquals(new SchemaIdentifier(new Uri($expected), $pointer), $context->getIdentifier());
    }

    /**
     * @return non-empty-list<array{string, string}>
     */
    public function valueProvider(): array
    {
        return [
            ['', 'https://example.com/a/b'],
            ['https://example.org', 'https://example.org'],
            ['/b', 'https://example.com/b'],
            ['c', 'https://example.com/a/c'],
            ['#', 'https://example.com/a/b'],
            ['/c/../d', 'https://example.com/d'],
        ];
    }

    /**
     * @param JsonNull|JsonString $value
     *
     * @dataProvider valueWithInvalidValueProvider
     */
    public function testProcessWithInvalidValue(JsonValue $value): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['$id' => $this->keyword], $identifier);

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['$id' => $value], $pointer, $context);
    }

    /**
     * @return non-empty-list<array{JsonNull|JsonString}>
     */
    public function valueWithInvalidValueProvider(): array
    {
        return [
            [new JsonNull()],
            [new JsonString('#a')],
        ];
    }
}
