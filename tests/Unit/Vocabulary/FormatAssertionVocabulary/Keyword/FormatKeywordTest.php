<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\FormatAssertionVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\SchemaException;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaProcessor;
use Yakimun\JsonSchemaValidator\Vocabulary\FormatAssertionVocabulary\Keyword\FormatKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\FormatAssertionVocabulary\KeywordValidator\FormatKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\FormatAssertionVocabulary\Keyword\FormatKeyword
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\FormatAssertionVocabulary\KeywordValidator\FormatKeywordValidator
 */
final class FormatKeywordTest extends TestCase
{
    /**
     * @var FormatKeyword
     */
    private FormatKeyword $keyword;

    /**
     * @var SchemaContext
     */
    private SchemaContext $context;

    protected function setUp(): void
    {
        $this->keyword = new FormatKeyword();

        $uri = new Uri('https://example.com');
        $pointer = new JsonPointer();
        $processor = new SchemaProcessor(['format' => $this->keyword]);
        $identifier = new SchemaIdentifier($uri, $pointer, $pointer);

        $this->context = new SchemaContext($processor, $pointer, [$identifier]);
    }

    public function testGetName(): void
    {
        $this->assertSame('format', $this->keyword->getName());
    }

    public function testProcess(): void
    {
        $expected = [new FormatKeywordValidator('a')];
        $this->keyword->process(['format' => 'a'], $this->context);

        $this->assertEquals($expected, $this->context->getKeywordValidators());
    }

    public function testProcessWithInvalidValue(): void
    {
        $this->expectException(SchemaException::class);

        $this->keyword->process(['format' => null], $this->context);
    }
}
