<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ApplicatorVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\ProcessedSchema;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\NotKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\NotKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\NotKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\NotKeywordHandler
 */
final class NotKeywordTest extends TestCase
{
    /**
     * @var NotKeyword
     */
    private $keyword;

    protected function setUp(): void
    {
        $this->keyword = new NotKeyword();
    }

    public function testGetName(): void
    {
        $this->assertEquals('not', $this->keyword->getName());
    }

    public function testProcess(): void
    {
        $uri = new Uri('https://example.com');
        $pointer = new JsonPointer('not');
        $absoluteLocation = 'https://example.com#/not';
        $validator = new ObjectSchemaValidator($absoluteLocation, []);
        $keywordHandler = new NotKeywordHandler($absoluteLocation, $validator);
        $processedSchema = new ProcessedSchema($validator, new SchemaIdentifier($uri, $pointer), [], [], $pointer);
        $identifier = new SchemaIdentifier($uri, new JsonPointer());
        $context = new SchemaContext(['not' => $this->keyword], $identifier);
        $this->keyword->process(['not' => new JsonObject([], $pointer)], $context);

        $this->assertEquals([$keywordHandler], $context->getKeywordHandlers());
        $this->assertEquals([$processedSchema], $context->getProcessedSchemas());
    }

    public function testProcessWithInvalidValue(): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(['not' => $this->keyword], $identifier);
        $value = new JsonNull(new JsonPointer('additionalProperties'));

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['not' => $value], $context);
    }
}
