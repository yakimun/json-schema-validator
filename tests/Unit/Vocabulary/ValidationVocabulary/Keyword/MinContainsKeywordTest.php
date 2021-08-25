<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\SchemaException;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaProcessor;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\MinContainsKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MinContainsKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\MinContainsKeyword
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MinContainsKeywordValidator
 */
final class MinContainsKeywordTest extends TestCase
{
    /**
     * @var MinContainsKeyword
     */
    private MinContainsKeyword $keyword;

    /**
     * @var SchemaContext
     */
    private SchemaContext $context;

    protected function setUp(): void
    {
        $this->keyword = new MinContainsKeyword();

        $uri = new Uri('https://example.com');
        $pointer = new JsonPointer();
        $processor = new SchemaProcessor(['minContains' => $this->keyword]);
        $identifier = new SchemaIdentifier($uri, $pointer, $pointer);

        $this->context = new SchemaContext($processor, $pointer, [$identifier]);
    }

    public function testProcess(): void
    {
        $expected = [new MinContainsKeywordValidator(0)];
        $this->keyword->process(['contains' => true, 'minContains' => 0], $this->context);

        $this->assertEquals($expected, $this->context->getKeywordValidators());
    }

    public function testProcessWithInvalidValue(): void
    {
        $this->expectException(SchemaException::class);

        $this->keyword->process(['minContains' => null], $this->context);
    }

    public function testProcessWithNegativeValue(): void
    {
        $this->expectException(SchemaException::class);

        $this->keyword->process(['minContains' => -1], $this->context);
    }

    public function testProcessWithoutContains(): void
    {
        $this->keyword->process(['minContains' => 0], $this->context);

        $this->assertEmpty($this->context->getKeywordValidators());
    }
}
