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
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\ExclusiveMinimumKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatExclusiveMinimumKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntExclusiveMinimumKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\ExclusiveMinimumKeyword
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatExclusiveMinimumKeywordValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntExclusiveMinimumKeywordValidator
 */
final class ExclusiveMinimumKeywordTest extends TestCase
{
    /**
     * @var JsonPointer
     */
    private JsonPointer $pointer;

    /**
     * @var SchemaIdentifier
     */
    private SchemaIdentifier $identifier;

    /**
     * @var ExclusiveMinimumKeyword
     */
    private ExclusiveMinimumKeyword $keyword;

    /**
     * @var SchemaProcessor
     */
    private SchemaProcessor $processor;

    protected function setUp(): void
    {
        $this->pointer = new JsonPointer();
        $this->identifier = new SchemaIdentifier(new Uri('https://example.com'), $this->pointer, $this->pointer);
        $this->keyword = new ExclusiveMinimumKeyword();
        $this->processor = new SchemaProcessor(['exclusiveMinimum' => $this->keyword]);
    }

    public function testProcessWithIntValue(): void
    {
        $value = 0;
        $context = new SchemaContext(
            $this->processor,
            ['exclusiveMinimum' => $value],
            $this->pointer,
            $this->identifier,
            [],
        );
        $expected = [new IntExclusiveMinimumKeywordValidator($value)];
        $this->keyword->process($value, $context);

        $this->assertEquals($expected, $context->getKeywordValidators());
    }

    public function testProcessWithFloatValue(): void
    {
        $value = 0.0;
        $context = new SchemaContext(
            $this->processor,
            ['exclusiveMinimum' => $value],
            $this->pointer,
            $this->identifier,
            [],
        );
        $expected = [new FloatExclusiveMinimumKeywordValidator($value)];
        $this->keyword->process($value, $context);

        $this->assertEquals($expected, $context->getKeywordValidators());
    }

    public function testProcessWithInvalidValue(): void
    {
        $value = null;
        $context = new SchemaContext(
            $this->processor,
            ['exclusiveMinimum' => $value],
            $this->pointer,
            $this->identifier,
            [],
        );

        $this->expectException(SchemaException::class);

        $this->keyword->process($value, $context);
    }
}
