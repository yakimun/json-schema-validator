<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\CoreVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Exception\SchemaException;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaProcessor;
use Yakimun\JsonSchemaValidator\SchemaReference;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\DynamicAnchorKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator\DynamicAnchorKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\DynamicAnchorKeyword
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\SchemaReference
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator\DynamicAnchorKeywordValidator
 */
final class DynamicAnchorKeywordTest extends TestCase
{
    /**
     * @var DynamicAnchorKeyword
     */
    private DynamicAnchorKeyword $keyword;

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
        $this->keyword = new DynamicAnchorKeyword();
        $this->uri = new Uri('https://example.com');
        $this->pointer = new JsonPointer();

        $processor = new SchemaProcessor(['$dynamicAnchor' => $this->keyword]);
        $identifier = new SchemaIdentifier($this->uri, $this->pointer, $this->pointer);

        $this->context = new SchemaContext($processor, $identifier, $this->pointer);
    }

    public function testGetName(): void
    {
        $this->assertSame('$dynamicAnchor', $this->keyword->getName());
    }

    /**
     * @param string $value
     * @dataProvider valueProvider
     */
    public function testProcess(string $value): void
    {
        $uri = $this->uri->withFragment($value);
        $path = $this->pointer->addTokens('$dynamicAnchor');
        $expectedAnchors = [new SchemaReference($uri, $path)];
        $expectedValidators = [new DynamicAnchorKeywordValidator($value)];
        $this->keyword->process(['$dynamicAnchor' => $value], $this->context);

        $this->assertEquals($expectedAnchors, $this->context->getAnchors());
        $this->assertEquals($expectedValidators, $this->context->getKeywordValidators());
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

        $this->keyword->process(['$dynamicAnchor' => $value], $this->context);
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
