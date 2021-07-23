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
     * @var IdKeyword
     */
    private IdKeyword $keyword;

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
     * @var SchemaContext
     */
    private SchemaContext $context;

    protected function setUp(): void
    {
        $this->keyword = new IdKeyword();
        $this->uri = new Uri('https://example.com');
        $this->pointer = new JsonPointer();

        $processor = new SchemaProcessor(['$id' => $this->keyword]);

        $this->identifier = new SchemaIdentifier($this->uri, $this->pointer, $this->pointer);
        $this->context = new SchemaContext($processor, $this->pointer, [$this->identifier]);
    }

    public function testGetName(): void
    {
        $this->assertSame('$id', $this->keyword->getName());
    }

    /**
     * @param string $value
     * @dataProvider valueProvider
     */
    public function testProcess(string $value): void
    {
        $uri = UriResolver::resolve($this->uri, new Uri($value));
        $_ = (string)$uri;
        $fragment = new JsonPointer();
        $path = $this->pointer->addTokens('$id');
        $expected = [$this->identifier, new SchemaIdentifier($uri, $fragment, $path)];
        $this->keyword->process(['$id' => $value], $this->context);

        $this->assertEquals($expected, $this->context->getIdentifiers());
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
        $uri = UriResolver::resolve($this->uri, new Uri($value));
        $_ = (string)$uri;
        $fragment = new JsonPointer();
        $path = $this->pointer->addTokens('$id');
        $expected = [new SchemaIdentifier($uri, $fragment, $path)];
        $this->keyword->process(['$id' => $value], $this->context);

        $this->assertEquals($expected, $this->context->getIdentifiers());
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
        $this->expectException(SchemaException::class);

        $this->keyword->process(['$id' => $value], $this->context);
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
