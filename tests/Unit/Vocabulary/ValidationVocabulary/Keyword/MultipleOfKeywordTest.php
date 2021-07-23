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
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\MultipleOfKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatMultipleOfKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntMultipleOfKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\MultipleOfKeyword
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatMultipleOfKeywordValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntMultipleOfKeywordValidator
 */
final class MultipleOfKeywordTest extends TestCase
{
    /**
     * @var MultipleOfKeyword
     */
    private MultipleOfKeyword $keyword;

    /**
     * @var SchemaContext
     */
    private SchemaContext $context;

    protected function setUp(): void
    {
        $this->keyword = new MultipleOfKeyword();

        $uri = new Uri('https://example.com');
        $pointer = new JsonPointer();
        $processor = new SchemaProcessor(['multipleOf' => $this->keyword]);
        $identifier = new SchemaIdentifier($uri, $pointer, $pointer);

        $this->context = new SchemaContext($processor, $pointer, [$identifier]);
    }

    public function testGetName(): void
    {
        $this->assertSame('multipleOf', $this->keyword->getName());
    }

    public function testProcessWithIntValue(): void
    {
        $expected = [new IntMultipleOfKeywordValidator(1)];
        $this->keyword->process(['multipleOf' => 1], $this->context);

        $this->assertEquals($expected, $this->context->getKeywordValidators());
    }

    public function testProcessWithFloatValue(): void
    {
        $expected = [new FloatMultipleOfKeywordValidator(1)];
        $this->keyword->process(['multipleOf' => 1.0], $this->context);

        $this->assertEquals($expected, $this->context->getKeywordValidators());
    }

    public function testProcessWithInvalidValue(): void
    {
        $this->expectException(SchemaException::class);

        $this->keyword->process(['multipleOf' => null], $this->context);
    }

    public function testProcessWithNegativeIntValue(): void
    {
        $this->expectException(SchemaException::class);

        $this->keyword->process(['multipleOf' => -1], $this->context);
    }

    public function testProcessWithNegativeFloatValue(): void
    {
        $this->expectException(SchemaException::class);

        $this->keyword->process(['multipleOf' => -1.0], $this->context);
    }

    public function testProcessWithZeroValue(): void
    {
        $this->expectException(SchemaException::class);

        $this->keyword->process(['multipleOf' => 0], $this->context);
    }
}
