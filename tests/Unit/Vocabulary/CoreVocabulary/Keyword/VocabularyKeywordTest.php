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
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\VocabularyKeyword;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\VocabularyKeyword
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 */
final class VocabularyKeywordTest extends TestCase
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
     * @var VocabularyKeyword
     */
    private VocabularyKeyword $keyword;

    /**
     * @var SchemaProcessor
     */
    private SchemaProcessor $processor;

    protected function setUp(): void
    {
        $this->uri = new Uri('https://example.com');
        $this->pointer = new JsonPointer([]);
        $this->keyword = new VocabularyKeyword();
        $this->processor = new SchemaProcessor(['$vocabulary' => $this->keyword]);
    }

    /**
     * @param array<string, bool> $value
     * @dataProvider valueProvider
     */
    public function testProcess(array $value): void
    {
        $identifier = new SchemaIdentifier($this->uri, $this->pointer, $this->pointer);
        $context = new SchemaContext(
            $this->processor,
            ['$vocabulary' => (object)$value],
            $this->pointer,
            $identifier,
            [],
        );
        $expected = new SchemaContext(
            $this->processor,
            ['$vocabulary' => (object)$value],
            $this->pointer,
            $identifier,
            [],
        );

        /**
         * @psalm-suppress UnusedMethodCall
         */
        $this->keyword->process((object)$value, $context);

        $this->assertEquals($expected, $context);
    }

    /**
     * @return non-empty-list<array{array<string, bool>}>
     */
    public function valueProvider(): array
    {
        return [
            [[]],
            [['https://example.com/a' => true]],
            [['https://example.com/a' => false]],
            [['https://example.com/a' => true, 'https://example.com/b' => false]],
        ];
    }

    /**
     * @param object|null $value
     * @param list<string> $tokens
     * @dataProvider invalidValueProvider
     */
    public function testProcessWithInvalidValue(?object $value, array $tokens): void
    {
        $pointer = $this->pointer->addTokens($tokens);
        $identifier = new SchemaIdentifier($this->uri, $pointer, $pointer);
        $context = new SchemaContext($this->processor, ['$vocabulary' => $value], $pointer, $identifier, []);

        $this->expectException(SchemaException::class);

        /**
         * @psalm-suppress UnusedMethodCall
         */
        $this->keyword->process($value, $context);
    }

    /**
     * @return non-empty-list<array{object|null, list<string>}>
     */
    public function invalidValueProvider(): array
    {
        return [
            [null, []],
            [(object)['a' => true], []],
            [(object)['https://example.com/a/../b' => true], []],
            [(object)['https://example.com/a' => null], []],
            [(object)[], ['a']],
        ];
    }
}
