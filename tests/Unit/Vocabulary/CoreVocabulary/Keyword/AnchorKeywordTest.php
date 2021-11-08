<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\CoreVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Exception\SchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaAnchor;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaProcessor;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\AnchorKeyword;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\AnchorKeyword
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonString
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaAnchor
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\SchemaReference
 */
final class AnchorKeywordTest extends TestCase
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
     * @var SchemaIdentifier
     */
    private SchemaIdentifier $identifier;

    /**
     * @var AnchorKeyword
     */
    private AnchorKeyword $keyword;

    /**
     * @var SchemaProcessor
     */
    private SchemaProcessor $processor;

    protected function setUp(): void
    {
        $this->uri = new Uri('https://example.com');
        $this->pointer = new JsonPointer([]);
        $this->identifier = new SchemaIdentifier($this->uri, $this->pointer, $this->pointer);
        $this->keyword = new AnchorKeyword();
        $this->processor = new SchemaProcessor(['$anchor' => $this->keyword]);
    }

    /**
     * @param string $anchor
     * @dataProvider anchorProvider
     */
    public function testProcess(string $anchor): void
    {
        $value = new JsonString($anchor);
        $context = new SchemaContext($this->processor, ['$anchor' => $value], $this->pointer, $this->identifier, []);
        $uri = $this->uri->withFragment($anchor);
        $expected = [new SchemaAnchor($uri, false, $this->pointer->addTokens(['$anchor']))];
        $this->keyword->process($value, $context);

        $this->assertEquals($expected, $context->getAnchors());
    }

    /**
     * @return non-empty-list<array{string}>
     */
    public function anchorProvider(): array
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
     * @param JsonValue $value
     * @dataProvider invalidValueProvider
     */
    public function testProcessWithInvalidValue(JsonValue $value): void
    {
        $context = new SchemaContext($this->processor, ['$anchor' => $value], $this->pointer, $this->identifier, []);

        $this->expectException(SchemaException::class);

        $this->keyword->process($value, $context);
    }

    /**
     * @return non-empty-list<array{JsonValue}>
     */
    public function invalidValueProvider(): array
    {
        return [
            [new JsonString('')],
            [new JsonString('0')],
            [new JsonString('-')],
            [new JsonString('.')],
            [new JsonString('*')],
            [new JsonString('A*')],
            [new JsonNull()],
        ];
    }
}
