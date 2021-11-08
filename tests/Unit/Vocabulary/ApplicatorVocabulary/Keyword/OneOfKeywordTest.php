<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ApplicatorVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\SchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\ProcessedSchema;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaProcessor;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\OneOfKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\OneOfKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\OneOfKeyword
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonArray
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\OneOfKeywordValidator
 */
final class OneOfKeywordTest extends TestCase
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
     * @var OneOfKeyword
     */
    private OneOfKeyword $keyword;

    /**
     * @var SchemaProcessor
     */
    private SchemaProcessor $processor;

    protected function setUp(): void
    {
        $this->pointer = new JsonPointer([]);
        $this->identifier = new SchemaIdentifier(new Uri('https://example.com'), $this->pointer, $this->pointer);
        $this->keyword = new OneOfKeyword();
        $this->processor = new SchemaProcessor(['oneOf' => $this->keyword]);
    }

    /**
     * @param non-empty-list<JsonObject> $elements
     * @param non-empty-list<ProcessedSchema> $expectedProcessedSchemas
     * @dataProvider elementsProvider
     */
    public function testProcess(array $elements, array $expectedProcessedSchemas): void
    {
        $value = new JsonArray($elements);
        $context = new SchemaContext($this->processor, ['oneOf' => $value], $this->pointer, $this->identifier, []);

        $validators = [];

        foreach ($expectedProcessedSchemas as $processedSchema) {
            $validators[] = $processedSchema->getValidator();
        }

        $expectedKeywordValidators = [new OneOfKeywordValidator($validators)];
        $this->keyword->process($value, $context);

        $this->assertEquals($expectedKeywordValidators, $context->getKeywordValidators());
        $this->assertEquals($expectedProcessedSchemas, $context->getProcessedSchemas());
    }

    /**
     * @return non-empty-list<array{non-empty-list<JsonObject>, non-empty-list<ProcessedSchema>}>
     */
    public function elementsProvider(): array
    {
        $object1 = new JsonObject([]);
        $object2 = new JsonObject([]);

        $uri = new Uri('https://example.com');

        $pointer1 = new JsonPointer(['oneOf', '0']);
        $pointer2 = new JsonPointer(['oneOf', '1']);

        $validator1 = new ObjectSchemaValidator($uri, $pointer1, []);
        $validator2 = new ObjectSchemaValidator($uri, $pointer2, []);

        $identifier1 = new SchemaIdentifier($uri, $pointer1, $pointer1);
        $identifier2 = new SchemaIdentifier($uri, $pointer2, $pointer2);

        $processedSchema1 = new ProcessedSchema($validator1, $identifier1, [], [], []);
        $processedSchema2 = new ProcessedSchema($validator2, $identifier2, [], [], []);

        return [
            [[$object1], [$processedSchema1]],
            [[$object1, $object2], [$processedSchema1, $processedSchema2]],
        ];
    }

    /**
     * @param JsonValue $value
     * @dataProvider invalidValueProvider
     */
    public function testProcessWithInvalidValue(JsonValue $value): void
    {
        $context = new SchemaContext($this->processor, ['oneOf' => $value], $this->pointer, $this->identifier, []);

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
            [new JsonArray([])],
            [new JsonArray([new JsonNull()])],
        ];
    }
}
