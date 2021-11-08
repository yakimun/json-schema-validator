<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ApplicatorVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\SchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\ProcessedSchema;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaProcessor;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\PatternPropertiesKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\PatternPropertiesKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\PatternPropertiesKeyword
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\PatternPropertiesKeywordValidator
 */
final class PatternPropertiesKeywordTest extends TestCase
{
    /**
     * @var JsonPointer
     */
    private JsonPointer $pointer;

    /**
     * @var SchemaIdentifier
     */
    private SchemaIdentifier $identifier;

    /**
     * @var PatternPropertiesKeyword
     */
    private PatternPropertiesKeyword $keyword;

    /**
     * @var SchemaProcessor
     */
    private SchemaProcessor $processor;

    protected function setUp(): void
    {
        $this->pointer = new JsonPointer([]);
        $this->identifier = new SchemaIdentifier(new Uri('https://example.com'), $this->pointer, $this->pointer);
        $this->keyword = new PatternPropertiesKeyword();
        $this->processor = new SchemaProcessor(['patternProperties' => $this->keyword]);
    }

    /**
     * @param array<string, JsonObject> $properties
     * @param array<string, ProcessedSchema> $processedSchemas
     * @dataProvider propertiesProvider
     */
    public function testProcess(array $properties, array $processedSchemas): void
    {
        $value = new JsonObject($properties);
        $context = new SchemaContext(
            $this->processor,
            ['patternProperties' => $value],
            $this->pointer,
            $this->identifier,
            [],
        );

        $validators = [];

        foreach ($processedSchemas as $key => $processedSchema) {
            $validators['/' . $key . '/'] = $processedSchema->getValidator();
        }

        $expectedKeywordValidators = [new PatternPropertiesKeywordValidator($validators)];
        $expectedProcessedSchemas = array_values($processedSchemas);
        $this->keyword->process($value, $context);

        $this->assertEquals($expectedKeywordValidators, $context->getKeywordValidators());
        $this->assertEquals($expectedProcessedSchemas, $context->getProcessedSchemas());
    }

    /**
     * @return non-empty-list<array{array<string, JsonObject>, array<string, ProcessedSchema>}>
     */
    public function propertiesProvider(): array
    {
        $object1 = new JsonObject([]);
        $object2 = new JsonObject([]);

        $uri = new Uri('https://example.com');

        $pointer1 = new JsonPointer(['patternProperties', 'a']);
        $pointer2 = new JsonPointer(['patternProperties', 'b']);

        $validator1 = new ObjectSchemaValidator($uri, $pointer1, []);
        $validator2 = new ObjectSchemaValidator($uri, $pointer2, []);

        $identifier1 = new SchemaIdentifier($uri, $pointer1, $pointer1);
        $identifier2 = new SchemaIdentifier($uri, $pointer2, $pointer2);

        $processedSchema1 = new ProcessedSchema($validator1, $identifier1, [], [], []);
        $processedSchema2 = new ProcessedSchema($validator2, $identifier2, [], [], []);

        return [
            [[], []],
            [['a' => $object1], ['a' => $processedSchema1]],
            [['a' => $object1, 'b' => $object2], ['a' => $processedSchema1, 'b' => $processedSchema2]],
        ];
    }

    /**
     * @param JsonValue $value
     * @dataProvider invalidValueProvider
     */
    public function testProcessWithInvalidValue(JsonValue $value): void
    {
        $context = new SchemaContext(
            $this->processor,
            ['patternProperties' => $value],
            $this->pointer,
            $this->identifier,
            [],
        );

        $this->expectException(SchemaException::class);

        $this->keyword->process($value, $context);
    }

    /**
     * @return non-empty-list<array{JsonValue}>
     */
    public function invalidValueProvider(): array
    {
        return [
            [new JsonNull()],
            [new JsonObject(['a' => new JsonNull()])],
        ];
    }
}
