<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\FormatAnnotationVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\SchemaException;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaProcessor;
use Yakimun\JsonSchemaValidator\Vocabulary\FormatAnnotationVocabulary\Keyword\FormatKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\FormatAnnotationVocabulary\KeywordValidator\FormatKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\FormatAnnotationVocabulary\Keyword\FormatKeyword
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\FormatAnnotationVocabulary\KeywordValidator\FormatKeywordValidator
 */
final class FormatKeywordTest extends TestCase
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
     * @var FormatKeyword
     */
    private FormatKeyword $keyword;

    /**
     * @var SchemaProcessor
     */
    private SchemaProcessor $processor;

    protected function setUp(): void
    {
        $this->pointer = new JsonPointer();
        $this->identifier = new SchemaIdentifier(new Uri('https://example.com'), $this->pointer, $this->pointer);
        $this->keyword = new FormatKeyword();
        $this->processor = new SchemaProcessor(['format' => $this->keyword]);
    }

    public function testProcess(): void
    {
        $value = 'a';
        $context = new SchemaContext($this->processor, ['format' => $value], $this->pointer, $this->identifier, []);
        $expected = [new FormatKeywordValidator($value)];
        $this->keyword->process($value, $context);

        $this->assertEquals($expected, $context->getKeywordValidators());
    }

    public function testProcessWithInvalidValue(): void
    {
        $value = null;
        $context = new SchemaContext($this->processor, ['format' => $value], $this->pointer, $this->identifier, []);

        $this->expectException(SchemaException::class);

        $this->keyword->process($value, $context);
    }
}
