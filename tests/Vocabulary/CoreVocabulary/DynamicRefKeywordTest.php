<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\CoreVocabulary;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonPointer;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Schema\SchemaContext;
use Yakimun\JsonSchemaValidator\Schema\SchemaFactory;
use Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Schema\SchemaReference;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\DynamicRefKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\DynamicRefKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\DynamicRefKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonString
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaFactory
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaReference
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\DynamicRefKeywordHandler
 */
final class DynamicRefKeywordTest extends TestCase
{
    /**
     * @var DynamicRefKeyword
     */
    private $keyword;

    protected function setUp(): void
    {
        $this->keyword = new DynamicRefKeyword();
    }

    public function testGetName(): void
    {
        $this->assertEquals('$dynamicRef', $this->keyword->getName());
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
        $context = new SchemaContext(new SchemaFactory(['$dynamicRef' => $this->keyword]), $identifier);
        $path = new JsonPointer('$dynamicRef');
        $expectedUri = new Uri($expected);
        $this->keyword->process(['$dynamicRef' => new JsonString($value, $path)], $context);

        $this->assertEquals([new SchemaReference($expectedUri, $path)], $context->getReferences());
        $this->assertEquals([new DynamicRefKeywordHandler($expectedUri)], $context->getKeywordHandlers());
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
            ['#c', 'https://example.com/a/b#c'],
            ['/c/../d', 'https://example.com/d'],
        ];
    }

    public function testProcessWithInvalidValue(): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(new SchemaFactory(['$dynamicRef' => $this->keyword]), $identifier);

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['$dynamicRef' => new JsonNull(new JsonPointer('$dynamicRef'))], $context);
    }
}
