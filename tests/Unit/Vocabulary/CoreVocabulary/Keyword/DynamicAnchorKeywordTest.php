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
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\DynamicAnchorKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator\DynamicAnchorKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\DynamicAnchorKeyword
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonString
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaAnchor
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\SchemaReference
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator\DynamicAnchorKeywordValidator
 */
final class DynamicAnchorKeywordTest extends TestCase
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
     * @var DynamicAnchorKeyword
     */
    private DynamicAnchorKeyword $keyword;

    /**
     * @var SchemaProcessor
     */
    private SchemaProcessor $processor;

    protected function setUp(): void
    {
        $this->uri = new Uri('https://example.com');
        $this->pointer = new JsonPointer([]);
        $this->identifier = new SchemaIdentifier($this->uri, $this->pointer, $this->pointer);
        $this->keyword = new DynamicAnchorKeyword();
        $this->processor = new SchemaProcessor(['$dynamicAnchor' => $this->keyword]);
    }

    /**
     * @param string $dynamicAnchor
     * @dataProvider dynamicAnchorProvider
     */
    public function testProcess(string $dynamicAnchor): void
    {
        $value = new JsonString($dynamicAnchor);
        $context = new SchemaContext(
            $this->processor,
            ['$dynamicAnchor' => $value],
            $this->pointer,
            $this->identifier,
            [],
        );
        $uri = $this->uri->withFragment($dynamicAnchor);
        $path = $this->pointer->addTokens(['$dynamicAnchor']);
        $expectedAnchors = [new SchemaAnchor($uri, true, $path)];
        $expectedValidators = [new DynamicAnchorKeywordValidator($dynamicAnchor)];
        $this->keyword->process($value, $context);

        $this->assertEquals($expectedAnchors, $context->getAnchors());
        $this->assertEquals($expectedValidators, $context->getKeywordValidators());
    }

    /**
     * @return non-empty-list<array{string}>
     */
    public function dynamicAnchorProvider(): array
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
        $context = new SchemaContext(
            $this->processor,
            ['$dynamicAnchor' => $value],
            $this->pointer,
            $this->identifier,
            [],
        );

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
