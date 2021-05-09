<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\DependentRequiredKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\DependentRequiredKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\DependentRequiredKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonArray
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonString
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\DependentRequiredKeywordHandler
 */
final class DependentRequiredKeywordTest extends TestCase
{
    /**
     * @var DependentRequiredKeyword
     */
    private $keyword;

    protected function setUp(): void
    {
        $this->keyword = new DependentRequiredKeyword();
    }

    public function testGetName(): void
    {
        $this->assertEquals('dependentRequired', $this->keyword->getName());
    }

    public function testProcess(): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(['dependentRequired' => $this->keyword], $identifier);
        $keywordHandler = new DependentRequiredKeywordHandler('https://example.com#/dependentRequired', ['a' => ['b']]);
        $items = [new JsonString('b', new JsonPointer('dependentRequired', 'a', '0'))];
        $properties = ['a' => new JsonArray($items, new JsonPointer('dependentRequired', 'a'))];
        $value = new JsonObject($properties, new JsonPointer('dependentRequired'));
        $this->keyword->process(['dependentRequired' => $value], $context);

        $this->assertEquals([$keywordHandler], $context->getKeywordHandlers());
    }

    public function testProcessWithInvalidValue(): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(['dependentRequired' => $this->keyword], $identifier);

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['dependentRequired' => new JsonNull(new JsonPointer('dependentRequired'))], $context);
    }

    public function testProcessWithInvalidObjectProperty(): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(['dependentRequired' => $this->keyword], $identifier);
        $properties = ['a' => new JsonNull(new JsonPointer('dependentRequired', 'a'))];
        $value = new JsonObject($properties, new JsonPointer('dependentRequired'));

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['dependentRequired' => $value], $context);
    }

    public function testProcessWithInvalidArrayItem(): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(['dependentRequired' => $this->keyword], $identifier);
        $items = [new JsonNull(new JsonPointer('dependentRequired', 'a', '0'))];
        $properties = ['a' => new JsonArray($items, new JsonPointer('dependentRequired', 'a'))];
        $value = new JsonObject($properties, new JsonPointer('dependentRequired'));

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['dependentRequired' => $value], $context);
    }

    public function testProcessWithNotUniqueArrayItems(): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(['dependentRequired' => $this->keyword], $identifier);
        $items = [
            new JsonString('b', new JsonPointer('dependentRequired', 'a', '0')),
            new JsonString('b', new JsonPointer('dependentRequired', 'a', '1')),
        ];
        $properties = ['a' => new JsonArray($items, new JsonPointer('dependentRequired', 'a'))];
        $value = new JsonObject($properties, new JsonPointer('dependentRequired'));

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['dependentRequired' => $value], $context);
    }
}
