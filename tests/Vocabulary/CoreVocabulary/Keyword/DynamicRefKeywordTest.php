<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\CoreVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\UriResolver;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Exception\SchemaException;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaProcessor;
use Yakimun\JsonSchemaValidator\SchemaReference;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\DynamicRefKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator\DynamicRefKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\DynamicRefKeyword
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\SchemaReference
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator\DynamicRefKeywordValidator
 */
final class DynamicRefKeywordTest extends TestCase
{
    /**
     * @var DynamicRefKeyword
     */
    private DynamicRefKeyword $keyword;

    /**
     * @var UriInterface
     */
    private UriInterface $uri;

    /**
     * @var JsonPointer
     */
    private JsonPointer $pointer;

    /**
     * @var SchemaContext
     */
    private SchemaContext $context;

    protected function setUp(): void
    {
        $this->keyword = new DynamicRefKeyword();
        $this->uri = new Uri('https://example.com');
        $this->pointer = new JsonPointer();

        $processor = new SchemaProcessor(['$dynamicRef' => $this->keyword]);
        $identifier = new SchemaIdentifier($this->uri, $this->pointer, $this->pointer);

        $this->context = new SchemaContext($processor, $identifier, $this->pointer);
    }

    public function testGetName(): void
    {
        $this->assertSame('$dynamicRef', $this->keyword->getName());
    }

    /**
     * @param string $value
     * @dataProvider valueProvider
     */
    public function testProcess(string $value): void
    {
        $uri = UriResolver::resolve($this->uri, new Uri($value));
        $path = $this->pointer->addTokens('$dynamicRef');
        $expectedReferences = [new SchemaReference($uri, $path)];
        $expectedValidators = [new DynamicRefKeywordValidator($uri)];
        $this->keyword->process(['$dynamicRef' => $value], $this->context);

        $this->assertEquals($expectedReferences, $this->context->getReferences());
        $this->assertEquals($expectedValidators, $this->context->getKeywordValidators());
    }

    /**
     * @return non-empty-list<array{string}>
     */
    public function valueProvider(): array
    {
        return [
            [''],
            ['https://example.org'],
            ['/a'],
            ['a'],
            ['#'],
            ['#a'],
            ['/a/../b'],
        ];
    }

    public function testProcessWithInvalidValue(): void
    {
        $this->expectException(SchemaException::class);

        $this->keyword->process(['$dynamicRef' => null], $this->context);
    }
}
