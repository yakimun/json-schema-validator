<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ApplicatorVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\SchemaException;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\ProcessedSchema;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaProcessor;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\AllOfKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\AllOfKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\AllOfKeyword
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\AllOfKeywordValidator
 */
final class AllOfKeywordTest extends TestCase
{
    /**
     * @var AllOfKeyword
     */
    private AllOfKeyword $keyword;

    /**
     * @var SchemaContext
     */
    private SchemaContext $context;

    protected function setUp(): void
    {
        $this->keyword = new AllOfKeyword();

        $uri = new Uri('https://example.com');
        $pointer = new JsonPointer();
        $processor = new SchemaProcessor(['allOf' => $this->keyword]);
        $identifier = new SchemaIdentifier($uri, $pointer, $pointer);

        $this->context = new SchemaContext($processor, $identifier, $pointer);
    }

    public function testGetName(): void
    {
        $this->assertSame('allOf', $this->keyword->getName());
    }

    /**
     * @param non-empty-list<object> $value
     * @param non-empty-list<ProcessedSchema> $expectedProcessedSchemas
     * @dataProvider valueProvider
     */
    public function testProcess(array $value, array $expectedProcessedSchemas): void
    {
        $validators = [];

        foreach ($expectedProcessedSchemas as $processedSchema) {
            $validators[] = $processedSchema->getValidator();
        }

        $expectedKeywordValidators = [new AllOfKeywordValidator($validators)];
        $this->keyword->process(['allOf' => $value], $this->context);

        $this->assertEquals($expectedKeywordValidators, $this->context->getKeywordValidators());
        $this->assertEquals($expectedProcessedSchemas, $this->context->getProcessedSchemas());
    }

    /**
     * @return non-empty-list<array{non-empty-list<object>, non-empty-list<ProcessedSchema>}>
     */
    public function valueProvider(): array
    {
        $object1 = (object)[];
        $object2 = (object)[];

        $uri = new Uri('https://example.com');

        $pointer1 = new JsonPointer('allOf', '0');
        $pointer2 = new JsonPointer('allOf', '1');

        $validator1 = new ObjectSchemaValidator($uri, $pointer1, []);
        $validator2 = new ObjectSchemaValidator($uri, $pointer2, []);

        $identifier1 = new SchemaIdentifier($uri, $pointer1, $pointer1);
        $identifier2 = new SchemaIdentifier($uri, $pointer2, $pointer2);

        $processedSchema1 = new ProcessedSchema($validator1, $identifier1, [], []);
        $processedSchema2 = new ProcessedSchema($validator2, $identifier2, [], []);

        return [
            [[$object1], [$processedSchema1]],
            [[$object1, $object2], [$processedSchema1, $processedSchema2]],
        ];
    }

    /**
     * @param list<null>|null $value
     * @dataProvider invalidValueProvider
     */
    public function testProcessWithInvalidValue(?array $value): void
    {
        $this->expectException(SchemaException::class);

        $this->keyword->process(['allOf' => $value], $this->context);
    }

    /**
     * @return non-empty-list<array{list<null>|null}>
     */
    public function invalidValueProvider(): array
    {
        return [
            [null],
            [[]],
            [[null]],
        ];
    }
}
