<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\CoreVocabulary;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonPointer;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\Schema\SchemaContext;
use Yakimun\JsonSchemaValidator\Schema\SchemaFactory;
use Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\IdKeyword;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\IdKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonString
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaFactory
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier
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
        $identifier = new SchemaIdentifier(new Uri('https://example.com/a/b'), new JsonPointer());
        $context = new SchemaContext(new SchemaFactory(['$id' => $this->keyword]), $identifier);
        $this->keyword->process(['$id' => new JsonString($value, new JsonPointer('$id'))], $context);

        $this->assertEquals(new SchemaIdentifier(new Uri($expected), new JsonPointer()), $context->getIdentifier());
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
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(new SchemaFactory(['$id' => $this->keyword]), $identifier);

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['$id' => $value], $context);
    }

    /**
     * @return non-empty-list<array{JsonNull|JsonString}>
     */
    public function valueWithInvalidValueProvider(): array
    {
        $path = new JsonPointer('$id');

        return [
            [new JsonNull($path)],
            [new JsonString('#a', $path)],
        ];
    }
}
