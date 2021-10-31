<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\MetaDataVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaProcessor;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword\DefaultKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\DefaultKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword\DefaultKeyword
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\DefaultKeywordValidator
 */
final class DefaultKeywordTest extends TestCase
{
    public function testProcess(): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer, $pointer);
        $keyword = new DefaultKeyword();
        $processor = new SchemaProcessor(['default' => $keyword]);
        $value = null;
        $context = new SchemaContext($processor, ['default' => $value], $pointer, $identifier, []);
        $expected = [new DefaultKeywordValidator($value)];
        $keyword->process($value, $context);

        $this->assertEquals($expected, $context->getKeywordValidators());
    }
}
