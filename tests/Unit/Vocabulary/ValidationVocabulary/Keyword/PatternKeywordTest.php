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
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\PatternKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\PatternKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\PatternKeyword
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\PatternKeywordValidator
 */
final class PatternKeywordTest extends TestCase
{
    /**
     * @var PatternKeyword
     */
    private PatternKeyword $keyword;

    /**
     * @var SchemaContext
     */
    private SchemaContext $context;

    protected function setUp(): void
    {
        $this->keyword = new PatternKeyword();

        $uri = new Uri('https://example.com');
        $pointer = new JsonPointer();
        $processor = new SchemaProcessor(['pattern' => $this->keyword]);
        $identifier = new SchemaIdentifier($uri, $pointer, $pointer);

        $this->context = new SchemaContext($processor, $pointer, [$identifier]);
    }

    public function testProcess(): void
    {
        $expected = [new PatternKeywordValidator('/.*a.*/')];
        $this->keyword->process(['pattern' => 'a'], $this->context);

        $this->assertEquals($expected, $this->context->getKeywordValidators());
    }

    public function testProcessWithInvalidValue(): void
    {
        $this->expectException(SchemaException::class);

        $this->keyword->process(['pattern' => null], $this->context);
    }
}
