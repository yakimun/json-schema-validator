<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\CoreVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Exception\SchemaException;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaProcessor;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\SchemaKeyword;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\SchemaKeyword
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 */
final class SchemaKeywordTest extends TestCase
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
     * @var SchemaKeyword
     */
    private SchemaKeyword $keyword;

    /**
     * @var SchemaProcessor
     */
    private SchemaProcessor $processor;

    protected function setUp(): void
    {
        $this->uri = new Uri('https://example.com');
        $this->pointer = new JsonPointer();
        $this->keyword = new SchemaKeyword();
        $this->processor = new SchemaProcessor(['$schema' => $this->keyword]);
    }

    /**
     * @param non-empty-array<string, string> $properties
     * @dataProvider propertiesProvider
     */
    public function testProcess(array $properties): void
    {
        $identifier = new SchemaIdentifier($this->uri, $this->pointer, $this->pointer);
        $context = new SchemaContext($this->processor, $properties, $this->pointer, $identifier, []);
        $expected = new SchemaContext($this->processor, $properties, $this->pointer, $identifier, []);

        /**
         * @psalm-suppress UnusedMethodCall
         */
        $this->keyword->process($properties['$schema'], $context);

        $this->assertEquals($expected, $context);
    }

    /**
     * @return non-empty-list<array{non-empty-array<string, string>}>
     */
    public function propertiesProvider(): array
    {
        return [
            [['$schema' => 'https://example.org/a']],
            [['$schema' => 'https://example.org/a', '$id' => 'b']],
        ];
    }

    /**
     * @param string|null $value
     * @param list<string> $tokens
     * @dataProvider invalidValueProvider
     */
    public function testProcessWithInvalidValue(?string $value, array $tokens): void
    {
        $pointer = $this->pointer->addTokens(...$tokens);
        $identifier = new SchemaIdentifier($this->uri, $pointer, $pointer);
        $context = new SchemaContext($this->processor, ['$schema' => $value], $pointer, $identifier, []);

        $this->expectException(SchemaException::class);

        /**
         * @psalm-suppress UnusedMethodCall
         */
        $this->keyword->process($value, $context);
    }

    /**
     * @return non-empty-list<array{string|null, list<string>}>
     */
    public function invalidValueProvider(): array
    {
        return [
            [null, []],
            ['/a', []],
            ['https://example.com/a/../b', []],
            ['https://example.com/a', ['b']],
        ];
    }
}
