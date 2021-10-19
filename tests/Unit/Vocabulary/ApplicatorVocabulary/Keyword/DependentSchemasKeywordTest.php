<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ApplicatorVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\SchemaException;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\ProcessedSchema;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaProcessor;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\DependentSchemasKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\DependentSchemasKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\DependentSchemasKeyword
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\DependentSchemasKeywordValidator
 */
final class DependentSchemasKeywordTest extends TestCase
{
    /**
     * @var DependentSchemasKeyword
     */
    private DependentSchemasKeyword $keyword;

    /**
     * @var SchemaContext
     */
    private SchemaContext $context;

    protected function setUp(): void
    {
        $this->keyword = new DependentSchemasKeyword();

        $uri = new Uri('https://example.com');
        $pointer = new JsonPointer();
        $processor = new SchemaProcessor(['dependentSchemas' => $this->keyword]);
        $identifier = new SchemaIdentifier($uri, $pointer, $pointer);

        $this->context = new SchemaContext($processor, $pointer, $identifier, []);
    }

    /**
     * @param array<string, object> $value
     * @param array<string, ProcessedSchema> $processedSchemas
     * @dataProvider propertyProvider
     */
    public function testProcess(array $value, array $processedSchemas): void
    {
        $validators = [];

        foreach ($processedSchemas as $key => $processedSchema) {
            $validators[$key] = $processedSchema->getValidator();
        }

        $expectedKeywordValidators = [new DependentSchemasKeywordValidator($validators)];
        $expectedProcessedSchemas = array_values($processedSchemas);
        $this->keyword->process(['dependentSchemas' => (object)$value], $this->context);

        $this->assertEquals($expectedKeywordValidators, $this->context->getKeywordValidators());
        $this->assertEquals($expectedProcessedSchemas, $this->context->getProcessedSchemas());
    }

    /**
     * @return non-empty-list<array{array<string, object>, array<string, ProcessedSchema>}>
     */
    public function propertyProvider(): array
    {
        $object1 = (object)[];
        $object2 = (object)[];

        $uri = new Uri('https://example.com');

        $pointer1 = new JsonPointer('dependentSchemas', 'a');
        $pointer2 = new JsonPointer('dependentSchemas', 'b');

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
     * @param object|null $value
     * @dataProvider invalidValueProvider
     */
    public function testProcessWithInvalidValue(?object $value): void
    {
        $this->expectException(SchemaException::class);

        $this->keyword->process(['dependentSchemas' => $value], $this->context);
    }

    /**
     * @return non-empty-list<array{object|null}>
     */
    public function invalidValueProvider(): array
    {
        return [
            [null],
            [(object)['a' => null]],
        ];
    }
}
