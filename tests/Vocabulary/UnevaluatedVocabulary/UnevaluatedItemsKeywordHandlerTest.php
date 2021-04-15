<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\UnevaluatedVocabulary;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonPointer;
use Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaValidator\TrueSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\UnevaluatedItemsKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\UnevaluatedItemsKeywordHandler
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\TrueSchemaValidator
 */
final class UnevaluatedItemsKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $schemaValidator = new TrueSchemaValidator($identifier);
        $keywordHandler = new UnevaluatedItemsKeywordHandler($schemaValidator);

        $this->assertInstanceOf(UnevaluatedItemsKeywordHandler::class, $keywordHandler);
    }
}
