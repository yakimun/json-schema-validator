<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Exception\SchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonBoolean;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\ProcessedSchema;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaProcessor;
use Yakimun\JsonSchemaValidator\SchemaValidator\BooleanSchemaValidator;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\UnknownKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\TypeKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\StringTypeKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonBoolean
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonString
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\BooleanSchemaValidator
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\UnknownKeywordValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\TypeKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\StringTypeKeywordValidator
 */
final class SchemaProcessorTest extends TestCase
{
    /**
     * @var UriInterface
     */
    private UriInterface $uri;

    /**
     * @var JsonPointer
     */
    private JsonPointer $pointer;

    /**
     * @var SchemaIdentifier
     */
    private SchemaIdentifier $identifier;

    /**
     * @var string
     */
    private string $keywordName;

    /**
     * @var SchemaProcessor
     */
    private SchemaProcessor $processor;

    protected function setUp(): void
    {
        $this->uri = new Uri('https://example.com');
        $this->pointer = new JsonPointer([]);
        $this->identifier = new SchemaIdentifier($this->uri, $this->pointer, $this->pointer);
        $this->keywordName = 'type';
        $this->processor = new SchemaProcessor([$this->keywordName => new TypeKeyword()]);
    }

    public function testProcessWithEmptyObjectSchema(): void
    {
        $validator = new ObjectSchemaValidator($this->uri, $this->pointer, []);
        $expected = [new ProcessedSchema($validator, $this->identifier, [], [], [])];

        $this->assertEquals(
            $expected,
            $this->processor->process(new JsonObject([]), $this->identifier, [], $this->pointer),
        );
    }

    public function testProcessWithKnownKeyword(): void
    {
        $type = 'null';
        $schema = new JsonObject([$this->keywordName => new JsonString($type)]);
        $validator = new ObjectSchemaValidator($this->uri, $this->pointer, [new StringTypeKeywordValidator($type)]);
        $expected = [new ProcessedSchema($validator, $this->identifier, [], [], [])];

        $this->assertEquals($expected, $this->processor->process($schema, $this->identifier, [], $this->pointer));
    }

    public function testProcessWithUnknownKeyword(): void
    {
        $keywordName = 'a';
        $value = new JsonNull();
        $schema = new JsonObject([$keywordName => $value]);
        $keywordValidator = new UnknownKeywordValidator($keywordName, $value);
        $validator = new ObjectSchemaValidator($this->uri, $this->pointer, [$keywordValidator]);
        $expected = [new ProcessedSchema($validator, $this->identifier, [], [], [])];

        $this->assertEquals($expected, $this->processor->process($schema, $this->identifier, [], $this->pointer));
    }

    public function testProcessWithBooleanSchema(): void
    {
        $value = true;
        $schema = new JsonBoolean($value);
        $validator = new BooleanSchemaValidator($this->uri, $this->pointer, $value);
        $expected = [new ProcessedSchema($validator, $this->identifier, [], [], [])];

        $this->assertEquals($expected, $this->processor->process($schema, $this->identifier, [], $this->pointer));
    }

    public function testProcessWithInvalidSchema(): void
    {
        $this->expectException(SchemaException::class);

        $this->processor->process(new JsonNull(), $this->identifier, [], $this->pointer);
    }
}
