<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\CoreVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\UriResolver;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Exception\SchemaException;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaProcessor;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\IdKeyword;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\IdKeyword
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 */
final class IdKeywordTest extends TestCase
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
     * @var IdKeyword
     */
    private IdKeyword $keyword;

    /**
     * @var SchemaProcessor
     */
    private SchemaProcessor $processor;

    protected function setUp(): void
    {
        $this->uri = new Uri('https://example.com');
        $this->pointer = new JsonPointer([]);
        $this->identifier = new SchemaIdentifier($this->uri, $this->pointer, $this->pointer);
        $this->keyword = new IdKeyword();
        $this->processor = new SchemaProcessor(['$id' => $this->keyword]);
    }

    /**
     * @param string $value
     * @dataProvider valueProvider
     */
    public function testProcess(string $value): void
    {
        $context = new SchemaContext($this->processor, ['$id' => $value], $this->pointer, $this->identifier, []);
        $uri = UriResolver::resolve($this->uri, new Uri($value));
        $_ = (string)$uri;
        $expectedIdentifier = new SchemaIdentifier($uri, $this->pointer, $this->pointer->addTokens(['$id']));
        $expectedNonCanonicalIdentifiers = [$this->identifier];
        $this->keyword->process($value, $context);

        $this->assertEquals($expectedIdentifier, $context->getIdentifier());
        $this->assertEquals($expectedNonCanonicalIdentifiers, $context->getNonCanonicalIdentifiers());
    }

    /**
     * @return non-empty-list<array{string}>
     */
    public function valueProvider(): array
    {
        return [
            ['https://example.org'],
            ['/a'],
            ['a'],
            ['/a/../b'],
        ];
    }

    /**
     * @param string $value
     * @dataProvider currentUriValueProvider
     */
    public function testProcessWithCurrentUri(string $value): void
    {
        $context = new SchemaContext($this->processor, ['$id' => $value], $this->pointer, $this->identifier, []);
        $uri = UriResolver::resolve($this->uri, new Uri($value));
        $_ = (string)$uri;
        $expected = new SchemaIdentifier($uri, $this->pointer, $this->pointer->addTokens(['$id']));
        $this->keyword->process($value, $context);

        $this->assertEquals($expected, $context->getIdentifier());
        $this->assertEmpty($context->getNonCanonicalIdentifiers());
    }

    /**
     * @return non-empty-list<array{string}>
     */
    public function currentUriValueProvider(): array
    {
        return [
            [''],
            ['#'],
        ];
    }

    /**
     * @param string|null $value
     * @dataProvider invalidValueProvider
     */
    public function testProcessWithInvalidValue(?string $value): void
    {
        $context = new SchemaContext($this->processor, ['$id' => $value], $this->pointer, $this->identifier, []);

        $this->expectException(SchemaException::class);

        $this->keyword->process($value, $context);
    }

    /**
     * @return non-empty-list<array{string|null}>
     */
    public function invalidValueProvider(): array
    {
        return [
            ['#a'],
            [null],
        ];
    }
}
