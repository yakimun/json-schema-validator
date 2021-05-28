<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\CoreVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaReference;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\RefKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordHandler\RefKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\RefKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonString
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaReference
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordHandler\RefKeywordHandler
 */
final class RefKeywordTest extends TestCase
{
    /**
     * @var RefKeyword
     */
    private $keyword;

    protected function setUp(): void
    {
        $this->keyword = new RefKeyword();
    }

    public function testGetName(): void
    {
        $this->assertEquals('$ref', $this->keyword->getName());
    }

    /**
     * @param string $value
     * @param string $expected
     *
     * @dataProvider valueProvider
     */
    public function testProcess(string $value, string $expected): void
    {
        $pointer = new JsonPointer();
        $keywordPointer = new JsonPointer('$ref');
        $identifier = new SchemaIdentifier(new Uri('https://example.com/a/b'), $pointer);
        $context = new SchemaContext(['$ref' => $this->keyword], $identifier);
        $keywordHandler = new RefKeywordHandler('https://example.com/a/b#/$ref', $expected);
        $this->keyword->process(['$ref' => new JsonString($value)], $pointer, $context);

        $this->assertEquals([new SchemaReference(new Uri($expected), $keywordPointer)], $context->getReferences());
        $this->assertEquals([$keywordHandler], $context->getKeywordHandlers());
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
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['$ref' => $this->keyword], $identifier);

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['$ref' => new JsonNull()], $pointer, $context);
    }
}
