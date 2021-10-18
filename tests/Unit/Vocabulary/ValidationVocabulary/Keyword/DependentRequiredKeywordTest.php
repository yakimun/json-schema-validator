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
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\DependentRequiredKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\DependentRequiredKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\DependentRequiredKeyword
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\DependentRequiredKeywordValidator
 */
final class DependentRequiredKeywordTest extends TestCase
{
    /**
     * @var DependentRequiredKeyword
     */
    private DependentRequiredKeyword $keyword;

    /**
     * @var SchemaContext
     */
    private SchemaContext $context;

    protected function setUp(): void
    {
        $this->keyword = new DependentRequiredKeyword();

        $uri = new Uri('https://example.com');
        $pointer = new JsonPointer();
        $processor = new SchemaProcessor(['dependentRequired' => $this->keyword]);
        $identifier = new SchemaIdentifier($uri, $pointer, $pointer);

        $this->context = new SchemaContext($processor, $pointer, [$identifier]);
    }

    public function testProcess(): void
    {
        $expected = [new DependentRequiredKeywordValidator([])];
        $this->keyword->process(['dependentRequired' => (object)[]], $this->context);

        $this->assertEquals($expected, $this->context->getKeywordValidators());
    }

    public function testProcessWithNonEmptyObject(): void
    {
        $expected = [new DependentRequiredKeywordValidator(['a' => []])];
        $this->keyword->process(['dependentRequired' => (object)['a' => []]], $this->context);

        $this->assertEquals($expected, $this->context->getKeywordValidators());
    }

    public function testProcessWithInvalidValue(): void
    {
        $this->expectException(SchemaException::class);

        $this->keyword->process(['dependentRequired' => null], $this->context);
    }

    public function testProcessWithInvalidObjectProperty(): void
    {
        $this->expectException(SchemaException::class);

        $this->keyword->process(['dependentRequired' => (object)['a' => null]], $this->context);
    }

    public function testProcessWithInvalidArrayItem(): void
    {
        $this->expectException(SchemaException::class);

        $this->keyword->process(['dependentRequired' => (object)['a' => [null]]], $this->context);
    }

    public function testProcessWithNotUniqueArrayItems(): void
    {
        $this->expectException(SchemaException::class);

        $this->keyword->process(['dependentRequired' => (object)['a' => ['b', 'b']]], $this->context);
    }
}
