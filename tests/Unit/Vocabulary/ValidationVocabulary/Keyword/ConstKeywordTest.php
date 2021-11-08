<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaProcessor;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\ConstKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\ConstKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\ConstKeyword
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\ConstKeywordValidator
 */
final class ConstKeywordTest extends TestCase
{
    public function testProcess(): void
    {
        $pointer = new JsonPointer([]);
        $keyword = new ConstKeyword();
        $processor = new SchemaProcessor(['const' => $keyword]);
        $value = new JsonNull();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer, $pointer);
        $context = new SchemaContext($processor, ['const' => $value], $pointer, $identifier, []);
        $expected = [new ConstKeywordValidator($value)];
        $keyword->process($value, $context);

        $this->assertEquals($expected, $context->getKeywordValidators());
    }
}
