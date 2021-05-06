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
use Yakimun\JsonSchemaValidator\SchemaReference;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\DynamicAnchorKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordHandler\DynamicAnchorKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\DynamicAnchorKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonString
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaReference
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordHandler\DynamicAnchorKeywordHandler
 */
final class DynamicAnchorKeywordTest extends TestCase
{
    /**
     * @var DynamicAnchorKeyword
     */
    private $keyword;

    protected function setUp(): void
    {
        $this->keyword = new DynamicAnchorKeyword();
    }

    public function testGetName(): void
    {
        $this->assertEquals('$dynamicAnchor', $this->keyword->getName());
    }

    /**
     * @param string $value
     *
     * @dataProvider valueProvider
     */
    public function testProcess(string $value): void
    {
        $uri = new Uri('https://example.com');
        $identifier = new SchemaIdentifier($uri, new JsonPointer());
        $context = new SchemaContext(['$dynamicAnchor' => $this->keyword], $identifier);
        $path = new JsonPointer('$dynamicAnchor');
        $keywordHandler = new DynamicAnchorKeywordHandler('https://example.com#/$dynamicAnchor', $value);
        $this->keyword->process(['$dynamicAnchor' => new JsonString($value, $path)], $context);

        $this->assertEquals([new SchemaReference($uri->withFragment($value), $path)], $context->getAnchors());
        $this->assertEquals([$keywordHandler], $context->getKeywordHandlers());
    }

    /**
     * @return non-empty-list<array{string}>
     */
    public function valueProvider(): array
    {
        return [
            ['A'],
            ['a'],
            ['_'],
            ['AB'],
            ['Ab'],
            ['A0'],
            ['A-'],
            ['A_'],
            ['A.'],
            ['Abc'],
        ];
    }

    /**
     * @param JsonNull|JsonString $value
     *
     * @dataProvider valueProviderWithInvalidValue
     */
    public function testProcessWithInvalidValue(JsonValue $value): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(['$dynamicAnchor' => $this->keyword], $identifier);

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['$dynamicAnchor' => $value], $context);
    }

    /**
     * @return non-empty-list<array{JsonNull|JsonString}>
     */
    public function valueProviderWithInvalidValue(): array
    {
        $path = new JsonPointer('$dynamicAnchor');

        return [
            [new JsonNull($path)],
            [new JsonString('-', $path)],
            [new JsonString('', $path)],
            [new JsonString('.', $path)],
            [new JsonString('*', $path)],
            [new JsonString('A*', $path)],
        ];
    }
}
