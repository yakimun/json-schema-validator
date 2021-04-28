<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ApplicatorVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\ProcessedSchema;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\DependentSchemasKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\DependentSchemasKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\DependentSchemasKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\DependentSchemasKeywordHandler
 */
final class DependentSchemasKeywordTest extends TestCase
{
    /**
     * @var DependentSchemasKeyword
     */
    private $keyword;

    protected function setUp(): void
    {
        $this->keyword = new DependentSchemasKeyword();
    }

    public function testGetName(): void
    {
        $this->assertEquals('dependentSchemas', $this->keyword->getName());
    }

    /**
     * @param array<string, JsonObject> $properties
     * @param array<string, ProcessedSchema> $expected
     *
     * @dataProvider valueProvider
     */
    public function testProcess(array $properties, array $expected): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(['dependentSchemas' => $this->keyword], $identifier);
        $value = new JsonObject($properties, new JsonPointer('dependentSchemas'));
        $this->keyword->process(['dependentSchemas' => $value], $context);

        $schemaValidators = [];
        foreach ($expected as $key => $processedSchema) {
            $schemaValidators[$key] = $processedSchema->getValidator();
        }

        $this->assertEquals([new DependentSchemasKeywordHandler($schemaValidators)], $context->getKeywordHandlers());
        $this->assertEquals(array_values($expected), $context->getProcessedSchemas());
    }

    /**
     * @return non-empty-list<array{array<string, JsonObject>, array<string, ProcessedSchema>}>
     */
    public function valueProvider(): array
    {
        $uri = new Uri('https://example.com');

        $pointer1 = new JsonPointer('dependentSchemas', 'a');
        $pointer2 = new JsonPointer('dependentSchemas', 'b');

        $jsonObject1 = new JsonObject([], $pointer1);
        $jsonObject2 = new JsonObject([], $pointer2);

        $identifier1 = new SchemaIdentifier($uri, $pointer1);
        $identifier2 = new SchemaIdentifier($uri, $pointer2);

        $validator1 = new ObjectSchemaValidator([], $identifier1);
        $validator2 = new ObjectSchemaValidator([], $identifier2);

        $processedSchema1 = new ProcessedSchema($validator1, $identifier1, [], [], $pointer1);
        $processedSchema2 = new ProcessedSchema($validator2, $identifier2, [], [], $pointer2);

        return [
            [[], []],
            [['a' => $jsonObject1], ['a' => $processedSchema1]],
            [['b' => $jsonObject2], ['b' => $processedSchema2]],
            [['a' => $jsonObject1, 'b' => $jsonObject2], ['a' => $processedSchema1, 'b' => $processedSchema2]],
        ];
    }

    /**
     * @param JsonNull|JsonObject $value
     *
     * @dataProvider invalidValueProvider
     */
    public function testProcessWithInvalidValue(JsonValue $value): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(['dependentSchemas' => $this->keyword], $identifier);

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['dependentSchemas' => $value], $context);
    }

    /**
     * @return non-empty-list<array{JsonNull|JsonObject}>
     */
    public function invalidValueProvider(): array
    {
        $path = new JsonPointer('dependentSchemas');

        return [
            [new JsonNull($path)],
            [new JsonObject(['a' => new JsonNull(new JsonPointer('dependentSchemas', 'a'))], $path)]
        ];
    }
}