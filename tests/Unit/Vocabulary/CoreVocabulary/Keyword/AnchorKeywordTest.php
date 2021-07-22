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
use Yakimun\JsonSchemaValidator\SchemaReference;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\AnchorKeyword;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\AnchorKeyword
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\SchemaReference
 */
final class AnchorKeywordTest extends TestCase
{
    /**
     * @var AnchorKeyword
     */
    private AnchorKeyword $keyword;

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
        $this->keyword = new AnchorKeyword();
        $this->uri = new Uri('https://example.com');
        $this->pointer = new JsonPointer();

        $processor = new SchemaProcessor(['$anchor' => $this->keyword]);
        $identifier = new SchemaIdentifier($this->uri, $this->pointer, $this->pointer);

        $this->context = new SchemaContext($processor, $identifier, $this->pointer);
    }

    public function testGetName(): void
    {
        $this->assertSame('$anchor', $this->keyword->getName());
    }

    /**
     * @param string $value
     * @dataProvider valueProvider
     */
    public function testProcess(string $value): void
    {
        $expected = [new SchemaReference($this->uri->withFragment($value), $this->pointer->addTokens('$anchor'))];
        $this->keyword->process(['$anchor' => $value], $this->context);

        $this->assertEquals($expected, $this->context->getAnchors());
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
     * @param string|null $value
     * @dataProvider invalidValueProvider
     */
    public function testProcessWithInvalidValue(?string $value): void
    {
        $this->expectException(SchemaException::class);

        $this->keyword->process(['$anchor' => $value], $this->context);
    }

    /**
     * @return non-empty-list<array{string|null}>
     */
    public function invalidValueProvider(): array
    {
        return [
            [''],
            ['0'],
            ['-'],
            ['.'],
            ['*'],
            ['A*'],
            [null],
        ];
    }
}
