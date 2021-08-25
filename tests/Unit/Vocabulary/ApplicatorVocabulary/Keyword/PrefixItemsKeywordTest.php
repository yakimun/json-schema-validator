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
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\PrefixItemsKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\PrefixItemsKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\PrefixItemsKeyword
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\PrefixItemsKeywordValidator
 */
final class PrefixItemsKeywordTest extends TestCase
{
    /**
     * @var PrefixItemsKeyword
     */
    private PrefixItemsKeyword $keyword;

    /**
     * @var SchemaContext
     */
    private SchemaContext $context;

    protected function setUp(): void
    {
        $this->keyword = new PrefixItemsKeyword();

        $uri = new Uri('https://example.com');
        $pointer = new JsonPointer();
        $processor = new SchemaProcessor(['prefixItems' => $this->keyword]);
        $identifier = new SchemaIdentifier($uri, $pointer, $pointer);

        $this->context = new SchemaContext($processor, $pointer, [$identifier]);
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

        $expectedKeywordValidators = [new PrefixItemsKeywordValidator($validators)];
        $this->keyword->process(['prefixItems' => $value], $this->context);

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

        $pointer1 = new JsonPointer('prefixItems', '0');
        $pointer2 = new JsonPointer('prefixItems', '1');

        $validator1 = new ObjectSchemaValidator($uri, $pointer1, []);
        $validator2 = new ObjectSchemaValidator($uri, $pointer2, []);

        $identifier1 = new SchemaIdentifier($uri, $pointer1, $pointer1);
        $identifier2 = new SchemaIdentifier($uri, $pointer2, $pointer2);

        $processedSchema1 = new ProcessedSchema($validator1, [$identifier1], [], []);
        $processedSchema2 = new ProcessedSchema($validator2, [$identifier2], [], []);

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

        $this->keyword->process(['prefixItems' => $value], $this->context);
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
