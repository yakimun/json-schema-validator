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
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\ExclusiveMaximumKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatExclusiveMaximumKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntExclusiveMaximumKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\ExclusiveMaximumKeyword
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatExclusiveMaximumKeywordValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntExclusiveMaximumKeywordValidator
 */
final class ExclusiveMaximumKeywordTest extends TestCase
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
     * @var ExclusiveMaximumKeyword
     */
    private ExclusiveMaximumKeyword $keyword;

    /**
     * @var SchemaProcessor
     */
    private SchemaProcessor $processor;

    protected function setUp(): void
    {
        $this->pointer = new JsonPointer();
        $this->identifier = new SchemaIdentifier(new Uri('https://example.com'), $this->pointer, $this->pointer);
        $this->keyword = new ExclusiveMaximumKeyword();
        $this->processor = new SchemaProcessor(['exclusiveMaximum' => $this->keyword]);
    }

    public function testProcessWithIntValue(): void
    {
        $value = 0;
        $context = new SchemaContext(
            $this->processor,
            ['exclusiveMaximum' => $value],
            $this->pointer,
            $this->identifier,
            [],
        );
        $expected = [new IntExclusiveMaximumKeywordValidator($value)];
        $this->keyword->process($value, $context);

        $this->assertEquals($expected, $context->getKeywordValidators());
    }

    public function testProcessWithFloatValue(): void
    {
        $value = 0.0;
        $context = new SchemaContext(
            $this->processor,
            ['exclusiveMaximum' => $value],
            $this->pointer,
            $this->identifier,
            [],
        );
        $expected = [new FloatExclusiveMaximumKeywordValidator($value)];
        $this->keyword->process($value, $context);

        $this->assertEquals($expected, $context->getKeywordValidators());
    }

    public function testProcessWithInvalidValue(): void
    {
        $value = null;
        $context = new SchemaContext(
            $this->processor,
            ['exclusiveMaximum' => $value],
            $this->pointer,
            $this->identifier,
            [],
        );

        $this->expectException(SchemaException::class);

        $this->keyword->process($value, $context);
    }
}
