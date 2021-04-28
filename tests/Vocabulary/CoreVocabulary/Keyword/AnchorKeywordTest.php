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
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\AnchorKeyword;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\AnchorKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonString
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaReference
 */
final class AnchorKeywordTest extends TestCase
{
    /**
     * @var AnchorKeyword
     */
    private $keyword;

    protected function setUp(): void
    {
        $this->keyword = new AnchorKeyword();
    }

    public function testGetName(): void
    {
        $this->assertEquals('$anchor', $this->keyword->getName());
    }

    /**
     * @param string $value
     *
     * @dataProvider valueProvider
     */
    public function testProcess(string $value): void
    {
        $uri = new Uri('https://example.com');
        $context = new SchemaContext(['$anchor' => $this->keyword], new SchemaIdentifier($uri, new JsonPointer()));
        $path = new JsonPointer('$anchor');
        $this->keyword->process(['$anchor' => new JsonString($value, $path)], $context);

        $this->assertEquals([new SchemaReference($uri->withFragment($value), $path)], $context->getAnchors());
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
        $context = new SchemaContext(['$anchor' => $this->keyword], $identifier);

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['$anchor' => $value], $context);
    }

    /**
     * @return non-empty-list<array{JsonNull|JsonString}>
     */
    public function valueProviderWithInvalidValue(): array
    {
        $path = new JsonPointer('$anchor');

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