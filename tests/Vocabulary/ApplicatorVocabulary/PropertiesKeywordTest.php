<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ApplicatorVocabulary;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonPointer;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\Schema\ProcessedSchema;
use Yakimun\JsonSchemaValidator\Schema\SchemaContext;
use Yakimun\JsonSchemaValidator\Schema\SchemaFactory;
use Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\PropertiesKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\PropertiesKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\PropertiesKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\Schema\ObjectSchema
 * @uses \Yakimun\JsonSchemaValidator\Schema\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaFactory
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\PropertiesKeywordHandler
 */
final class PropertiesKeywordTest extends TestCase
{
    /**
     * @var PropertiesKeyword
     */
    private $keyword;

    protected function setUp(): void
    {
        $this->keyword = new PropertiesKeyword();
    }

    public function testGetName(): void
    {
        $this->assertEquals('properties', $this->keyword->getName());
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
        $context = new SchemaContext(new SchemaFactory(['properties' => $this->keyword]), $identifier);
        $this->keyword->process(['properties' => new JsonObject($properties, new JsonPointer('properties'))], $context);

        $schemaValidators = [];
        foreach ($expected as $key => $processedSchema) {
            $schemaValidators[$key] = $processedSchema->getValidator();
        }

        $this->assertEquals([new PropertiesKeywordHandler($schemaValidators)], $context->getKeywordHandlers());
        $this->assertEquals(array_values($expected), $context->getProcessedSchemas());
    }

    /**
     * @return non-empty-list<array{array<string, JsonObject>, array<string, ProcessedSchema>}>
     */
    public function valueProvider(): array
    {
        $uri = new Uri('https://example.com');

        $pointer1 = new JsonPointer('properties', 'a');
        $pointer2 = new JsonPointer('properties', 'b');

        $jsonObject1 = new JsonObject([], $pointer1);
        $jsonObject2 = new JsonObject([], $pointer2);

        $identifier1 = new SchemaIdentifier($uri, $pointer1);
        $identifier2 = new SchemaIdentifier($uri, $pointer2);

        $objectValidator1 = new ObjectSchemaValidator([], $identifier1);
        $objectValidator2 = new ObjectSchemaValidator([], $identifier2);

        $processedSchema1 = new ProcessedSchema($objectValidator1, $identifier1, [], []);
        $processedSchema2 = new ProcessedSchema($objectValidator2, $identifier2, [], []);

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
        $context = new SchemaContext(new SchemaFactory(['properties' => $this->keyword]), $identifier);

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['properties' => $value], $context);
    }

    /**
     * @return non-empty-list<array{JsonNull|JsonObject}>
     */
    public function invalidValueProvider(): array
    {
        $path = new JsonPointer('properties');

        return [
            [new JsonNull($path)],
            [new JsonObject(['a' => new JsonNull(new JsonPointer('properties', 'a'))], $path)]
        ];
    }
}
