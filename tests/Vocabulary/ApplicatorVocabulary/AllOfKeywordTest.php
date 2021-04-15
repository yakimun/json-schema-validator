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
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\AllOfKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\AllOfKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\AllOfKeyword
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
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\AllOfKeywordHandler
 */
final class AllOfKeywordTest extends TestCase
{
    /**
     * @var AllOfKeyword
     */
    private $keyword;

    protected function setUp(): void
    {
        $this->keyword = new AllOfKeyword();
    }

    public function testGetName(): void
    {
        $this->assertEquals('allOf', $this->keyword->getName());
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
        $context = new SchemaContext(new SchemaFactory(['allOf' => $this->keyword]), $identifier);
        $this->keyword->process(['allOf' => new JsonArray($items, new JsonPointer('allOf'))], $context);

        $schemaValidators = [];
        foreach ($expected as $processedSchema) {
            $schemaValidators[] = $processedSchema->getValidator();
        }

        $this->assertEquals([new AllOfKeywordHandler($schemaValidators)], $context->getKeywordHandlers());
        $this->assertEquals($expected, $context->getProcessedSchemas());
    }

    /**
     * @return non-empty-list<array{non-empty-list<JsonObject>, non-empty-list<ProcessedSchema>}>
     */
    public function valueProvider(): array
    {
        $uri = new Uri('https://example.com');

        $pointer1 = new JsonPointer('allOf', '0');
        $pointer2 = new JsonPointer('allOf', '1');

        $jsonObject1 = new JsonObject([], $pointer1);
        $jsonObject2 = new JsonObject([], $pointer2);

        $identifier1 = new SchemaIdentifier($uri, $pointer1);
        $identifier2 = new SchemaIdentifier($uri, $pointer2);

        $processedSchema1 = new ProcessedSchema(new ObjectSchemaValidator([], $identifier1), $identifier1, [], []);
        $processedSchema2 = new ProcessedSchema(new ObjectSchemaValidator([], $identifier2), $identifier2, [], []);

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
        $context = new SchemaContext(new SchemaFactory(['allOf' => $this->keyword]), $identifier);

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['allOf' => $value], $context);
    }

    /**
     * @return non-empty-list<array{JsonNull|JsonArray}>
     */
    public function invalidValueProvider(): array
    {
        $path = new JsonPointer('allOf');

        return [
            [new JsonNull($path)],
            [new JsonArray([], $path)],
            [new JsonArray([new JsonNull(new JsonPointer('allOf', '0'))], $path)]
        ];
    }
}
