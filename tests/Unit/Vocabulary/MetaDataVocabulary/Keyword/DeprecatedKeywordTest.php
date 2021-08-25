<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\MetaDataVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\SchemaException;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaProcessor;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword\DeprecatedKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\DeprecatedKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword\DeprecatedKeyword
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\DeprecatedKeywordValidator
 */
final class DeprecatedKeywordTest extends TestCase
{
    /**
     * @var DeprecatedKeyword
     */
    private DeprecatedKeyword $keyword;

    /**
     * @var SchemaContext
     */
    private SchemaContext $context;

    protected function setUp(): void
    {
        $this->keyword = new DeprecatedKeyword();

        $uri = new Uri('https://example.com');
        $pointer = new JsonPointer();
        $processor = new SchemaProcessor(['deprecated' => $this->keyword]);
        $identifier = new SchemaIdentifier($uri, $pointer, $pointer);

        $this->context = new SchemaContext($processor, $pointer, [$identifier]);
    }

    public function testProcess(): void
    {
        $expected = [new DeprecatedKeywordValidator(true)];
        $this->keyword->process(['deprecated' => true], $this->context);

        $this->assertEquals($expected, $this->context->getKeywordValidators());
    }

    public function testProcessWithInvalidValue(): void
    {
        $this->expectException(SchemaException::class);

        $this->keyword->process(['deprecated' => null], $this->context);
    }
}
