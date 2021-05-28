<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ApplicatorVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\ProcessedSchema;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\AnyOfKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\AnyOfKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\AnyOfKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonArray
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\AnyOfKeywordHandler
 */
final class AnyOfKeywordTest extends TestCase
{
    /**
     * @var AnyOfKeyword
     */
    private $keyword;

    protected function setUp(): void
    {
        $this->keyword = new AnyOfKeyword();
    }

    public function testGetName(): void
    {
        $this->assertEquals('anyOf', $this->keyword->getName());
    }

    /**
     * @param list<JsonObject> $items
     * @param list<ProcessedSchema> $expected
     *
     * @dataProvider valueProvider
     */
    public function testProcess(array $items, array $expected): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['anyOf' => $this->keyword], $identifier);
        $value = new JsonArray($items);
        $this->keyword->process(['anyOf' => $value], $pointer, $context);

        $validators = [];

        foreach ($expected as $processedSchema) {
            $validators[] = $processedSchema->getValidator();
        }

        $keywordHandler = new AnyOfKeywordHandler('https://example.com#/anyOf', $validators);

        $this->assertEquals([$keywordHandler], $context->getKeywordHandlers());
        $this->assertEquals($expected, $context->getProcessedSchemas());
    }

    /**
     * @return non-empty-list<array{non-empty-list<JsonObject>, non-empty-list<ProcessedSchema>}>
     */
    public function valueProvider(): array
    {
        $uri = new Uri('https://example.com');

        $pointer1 = new JsonPointer('anyOf', '0');
        $pointer2 = new JsonPointer('anyOf', '1');

        $jsonObject1 = new JsonObject([]);
        $jsonObject2 = new JsonObject([]);

        $identifier1 = new SchemaIdentifier($uri, $pointer1);
        $identifier2 = new SchemaIdentifier($uri, $pointer2);

        $validator1 = new ObjectSchemaValidator('https://example.com#/anyOf/0', []);
        $validator2 = new ObjectSchemaValidator('https://example.com#/anyOf/1', []);

        $processedSchema1 = new ProcessedSchema($validator1, $identifier1, [], [], $pointer1);
        $processedSchema2 = new ProcessedSchema($validator2, $identifier2, [], [], $pointer2);

        return [
            [[$jsonObject1], [$processedSchema1]],
            [[$jsonObject1, $jsonObject2], [$processedSchema1, $processedSchema2]],
        ];
    }

    /**
     * @param JsonNull|JsonArray $value
     *
     * @dataProvider invalidValueProvider
     */
    public function testProcessWithInvalidValue(JsonValue $value): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['anyOf' => $this->keyword], $identifier);

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['anyOf' => $value], $pointer, $context);
    }

    /**
     * @return non-empty-list<array{JsonNull|JsonArray}>
     */
    public function invalidValueProvider(): array
    {
        return [
            [new JsonNull()],
            [new JsonArray([])],
            [new JsonArray([new JsonNull()])],
        ];
    }
}
