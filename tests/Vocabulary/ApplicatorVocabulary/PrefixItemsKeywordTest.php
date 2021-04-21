<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ApplicatorVocabulary;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonPointer;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\Schema\ProcessedSchema;
use Yakimun\JsonSchemaValidator\Schema\SchemaContext;
use Yakimun\JsonSchemaValidator\Schema\SchemaFactory;
use Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\PrefixItemsKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\PrefixItemsKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\PrefixItemsKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonArray
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\Schema\ObjectSchema
 * @uses \Yakimun\JsonSchemaValidator\Schema\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaFactory
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\PrefixItemsKeywordHandler
 */
final class PrefixItemsKeywordTest extends TestCase
{
    /**
     * @var PrefixItemsKeyword
     */
    private $keyword;

    protected function setUp(): void
    {
        $this->keyword = new PrefixItemsKeyword();
    }

    public function testGetName(): void
    {
        $this->assertEquals('prefixItems', $this->keyword->getName());
    }

    /**
     * @param list<JsonObject> $items
     * @param list<ProcessedSchema> $expected
     *
     * @dataProvider valueProvider
     */
    public function testProcess(array $items, array $expected): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(new SchemaFactory(['prefixItems' => $this->keyword]), $identifier);
        $this->keyword->process(['prefixItems' => new JsonArray($items, new JsonPointer('prefixItems'))], $context);

        $schemaValidators = [];
        foreach ($expected as $processedSchema) {
            $schemaValidators[] = $processedSchema->getValidator();
        }

        $this->assertEquals([new PrefixItemsKeywordHandler($schemaValidators)], $context->getKeywordHandlers());
        $this->assertEquals($expected, $context->getProcessedSchemas());
    }

    /**
     * @return non-empty-list<array{non-empty-list<JsonObject>, non-empty-list<ProcessedSchema>}>
     */
    public function valueProvider(): array
    {
        $uri = new Uri('https://example.com');

        $pointer1 = new JsonPointer('prefixItems', '0');
        $pointer2 = new JsonPointer('prefixItems', '1');

        $jsonObject1 = new JsonObject([], $pointer1);
        $jsonObject2 = new JsonObject([], $pointer2);

        $identifier1 = new SchemaIdentifier($uri, $pointer1);
        $identifier2 = new SchemaIdentifier($uri, $pointer2);

        $objectValidator1 = new ObjectSchemaValidator([], $identifier1);
        $objectValidator2 = new ObjectSchemaValidator([], $identifier2);

        $processedSchema1 = new ProcessedSchema($objectValidator1, $identifier1, [], [], $pointer1);
        $processedSchema2 = new ProcessedSchema($objectValidator2, $identifier2, [], [], $pointer2);

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
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(new SchemaFactory(['prefixItems' => $this->keyword]), $identifier);

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['prefixItems' => $value], $context);
    }

    /**
     * @return non-empty-list<array{JsonNull|JsonArray}>
     */
    public function invalidValueProvider(): array
    {
        $path = new JsonPointer('prefixItems');

        return [
            [new JsonNull($path)],
            [new JsonArray([], $path)],
            [new JsonArray([new JsonNull(new JsonPointer('prefixItems', '0'))], $path)]
        ];
    }
}
