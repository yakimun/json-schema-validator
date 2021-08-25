<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\CoreVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\SchemaException;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\ProcessedSchema;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaProcessor;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\DefsKeyword;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\DefsKeyword
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 */
final class DefsKeywordTest extends TestCase
{
    /**
     * @var DefsKeyword
     */
    private DefsKeyword $keyword;

    /**
     * @var SchemaContext
     */
    private SchemaContext $context;

    protected function setUp(): void
    {
        $this->keyword = new DefsKeyword();

        $uri = new Uri('https://example.com');
        $pointer = new JsonPointer();
        $processor = new SchemaProcessor(['$defs' => $this->keyword]);
        $identifier = new SchemaIdentifier($uri, $pointer, $pointer);

        $this->context = new SchemaContext($processor, $pointer, [$identifier]);
    }

    /**
     * @param array<string, object> $properties
     * @param list<ProcessedSchema> $expected
     * @dataProvider propertyProvider
     */
    public function testProcess(array $properties, array $expected): void
    {
        $this->keyword->process(['$defs' => (object)$properties], $this->context);

        $this->assertEquals($expected, $this->context->getProcessedSchemas());
    }

    /**
     * @return non-empty-list<array{array<string, object>, list<ProcessedSchema>}>
     */
    public function propertyProvider(): array
    {
        $object1 = (object)[];
        $object2 = (object)[];

        $uri = new Uri('https://example.com');

        $pointer1 = new JsonPointer('$defs', 'a');
        $pointer2 = new JsonPointer('$defs', 'b');

        $validator1 = new ObjectSchemaValidator($uri, $pointer1, []);
        $validator2 = new ObjectSchemaValidator($uri, $pointer2, []);

        $identifier1 = new SchemaIdentifier($uri, $pointer1, $pointer1);
        $identifier2 = new SchemaIdentifier($uri, $pointer2, $pointer2);

        $processedSchema1 = new ProcessedSchema($validator1, [$identifier1], [], []);
        $processedSchema2 = new ProcessedSchema($validator2, [$identifier2], [], []);

        return [
            [[], []],
            [['a' => $object1], [$processedSchema1]],
            [['b' => $object2], [$processedSchema2]],
            [['a' => $object1, 'b' => $object2], [$processedSchema1, $processedSchema2]],
        ];
    }

    /**
     * @param object|null $value
     * @dataProvider invalidValueProvider
     */
    public function testProcessWithInvalidValue(?object $value): void
    {
        $this->expectException(SchemaException::class);

        $this->keyword->process(['$defs' => $value], $this->context);
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
