<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Exception\SchemaLoaderException;
use Yakimun\JsonSchemaValidator\Exception\ValidatorFactoryException;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaLoader\SchemaLoader;
use Yakimun\JsonSchemaValidator\SchemaLoaderResult;
use Yakimun\JsonSchemaValidator\SchemaValidator\BooleanSchemaValidator;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Validator;
use Yakimun\JsonSchemaValidator\ValidatorFactory;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator\DynamicAnchorKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator\DynamicRefKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator\RefKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\StringTypeKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\ValidatorFactory
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\SchemaAnchor
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaLoaderResult
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\SchemaReference
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\BooleanSchemaValidator
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 * @uses \Yakimun\JsonSchemaValidator\Validator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\ApplicatorVocabulary
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\AdditionalPropertiesKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\AllOfKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\AnyOfKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\ContainsKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\DependentSchemasKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\ElseKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\IfKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\ItemsKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\NotKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\OneOfKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\PrefixItemsKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\PropertiesKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\PropertyNamesKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\ThenKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\ContentVocabulary
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\Keyword\ContentEncodingKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\Keyword\ContentMediaTypeKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\Keyword\ContentSchemaKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\CoreVocabulary
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\AnchorKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\CommentKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\DefsKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\DynamicAnchorKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\DynamicRefKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\IdKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\RefKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\SchemaKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\VocabularyKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator\DynamicAnchorKeywordValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator\DynamicRefKeywordValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator\RefKeywordValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\FormatAnnotationVocabulary\FormatAnnotationVocabulary
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\FormatAnnotationVocabulary\Keyword\FormatKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\MetaDataVocabulary
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword\DefaultKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword\DeprecatedKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword\DescriptionKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword\ExamplesKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword\ReadOnlyKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword\TitleKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword\WriteOnlyKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\Keyword\UnevaluatedItemsKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\Keyword\UnevaluatedPropertiesKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\UnevaluatedVocabulary
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\ConstKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\DependentRequiredKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\EnumKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\ExclusiveMaximumKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\ExclusiveMinimumKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\MaxContainsKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\MaxItemsKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\MaxLengthKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\MaxPropertiesKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\MaximumKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\MinContainsKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\MinItemsKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\MinLengthKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\MinPropertiesKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\MinimumKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\MultipleOfKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\PatternKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\RequiredKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\TypeKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\UniqueItemsKeyword
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\StringTypeKeywordValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\ValidationVocabulary
 */
final class ValidatorFactoryTest extends TestCase
{
    /**
     * @var ValidatorFactory
     */
    private ValidatorFactory $factory;

    /**
     * @var UriInterface
     */
    private UriInterface $uri;

    /**
     * @var JsonPointer
     */
    private JsonPointer $pointer;

    protected function setUp(): void
    {
        $this->factory = new ValidatorFactory();
        $this->uri = new Uri('https://example.com');
        $this->pointer = new JsonPointer();
    }

    public function testCreateValidatorWithEmptyObjectSchema(): void
    {
        $expected = new Validator(new ObjectSchemaValidator($this->uri, $this->pointer, []), [], []);

        $this->assertEquals($expected, $this->factory->createValidator((object)[], $this->uri));
    }

    public function testCreateValidatorWithNonEmptyObjectSchema(): void
    {
        $schema = (object)['type' => 'null'];
        $keywordValidator = new StringTypeKeywordValidator('null');
        $expected = new Validator(new ObjectSchemaValidator($this->uri, $this->pointer, [$keywordValidator]), [], []);

        $this->assertEquals($expected, $this->factory->createValidator($schema, $this->uri));
    }

    public function testCreateValidatorWithIdentifier(): void
    {
        $schema = (object)['$id' => 'a'];
        $uri = new Uri('https://example.com/a');
        $_ = (string)$uri;
        $expected = new Validator(new ObjectSchemaValidator($uri, $this->pointer, []), [], []);

        $this->assertEquals($expected, $this->factory->createValidator($schema, $this->uri));
    }

    public function testCreateValidatorWithNonUniqueIdentifiers(): void
    {
        $schema = (object)['$id' => 'a', '$defs' => (object)['a' => (object)['$id' => 'a']]];

        $this->expectException(ValidatorFactoryException::class);

        $this->factory->createValidator($schema, $this->uri);
    }

    public function testCreateValidatorWithAnchor(): void
    {
        $schema = (object)['$anchor' => 'a'];
        $expected = new Validator(new ObjectSchemaValidator($this->uri, $this->pointer, []), [], []);

        $this->assertEquals($expected, $this->factory->createValidator($schema, $this->uri));
    }

    public function testCreateValidatorWithDynamicAnchor(): void
    {
        $schema = (object)['$dynamicAnchor' => 'a', '$dynamicRef' => '#a'];
        $uri = new Uri('https://example.com#a');
        $_ = (string)$uri;
        $dynamicAnchorKeywordValidator = new DynamicAnchorKeywordValidator('a');
        $dynamicRefKeywordValidator = new DynamicRefKeywordValidator($uri);
        $keywordValidators = [$dynamicAnchorKeywordValidator, $dynamicRefKeywordValidator];
        $schemaValidator = new ObjectSchemaValidator($this->uri, $this->pointer, $keywordValidators);
        $schemaValidators = ['https://example.com#a' => $schemaValidator];
        $dynamicUris = ['https://example.com#a'];
        $expected = new Validator($schemaValidator, $schemaValidators, $dynamicUris);

        $this->assertEquals($expected, $this->factory->createValidator($schema, $this->uri));
    }

    public function testCreateValidatorWithUnusedDynamicAnchor(): void
    {
        $schema = (object)['$dynamicAnchor' => 'a'];
        $keywordValidator = new DynamicAnchorKeywordValidator('a');
        $expected = new Validator(new ObjectSchemaValidator($this->uri, $this->pointer, [$keywordValidator]), [], []);

        $this->assertEquals($expected, $this->factory->createValidator($schema, $this->uri));
    }

    public function testCreateValidatorWithNonUniqueAnchors(): void
    {
        $schema = (object)['$anchor' => 'a', '$defs' => (object)['a' => (object)['$anchor' => 'a']]];

        $this->expectException(ValidatorFactoryException::class);

        $this->factory->createValidator($schema, $this->uri);
    }

    public function testCreateValidatorWithReference(): void
    {
        $schema = (object)['$ref' => '#/$defs/a', '$defs' => (object)['a' => (object)[]]];
        $uri = new Uri('https://example.com#/$defs/a');
        $pointer = new JsonPointer('$defs', 'a');
        $keywordValidator = new RefKeywordValidator($uri);
        $schemaValidator1 = new ObjectSchemaValidator($this->uri, $this->pointer, [$keywordValidator]);
        $schemaValidator2 = new ObjectSchemaValidator($this->uri, $pointer, []);
        $expected = new Validator($schemaValidator1, [(string)$uri => $schemaValidator2], []);

        $this->assertEquals($expected, $this->factory->createValidator($schema, $this->uri));
    }

    public function testCreateValidatorWithEqualReferences(): void
    {
        $schema = (object)['$ref' => '#/$defs/a', '$dynamicRef' => '#/$defs/a', '$defs' => (object)['a' => (object)[]]];
        $uri = new Uri('https://example.com#/$defs/a');
        $pointer = new JsonPointer('$defs', 'a');
        $refKeywordValidator = new RefKeywordValidator($uri);
        $dynamicRefKeywordValidator = new DynamicRefKeywordValidator($uri);
        $keywordValidators = [$refKeywordValidator, $dynamicRefKeywordValidator];
        $schemaValidator1 = new ObjectSchemaValidator($this->uri, $this->pointer, $keywordValidators);
        $schemaValidator2 = new ObjectSchemaValidator($this->uri, $pointer, []);
        $expected = new Validator($schemaValidator1, [(string)$uri => $schemaValidator2], []);

        $this->assertEquals($expected, $this->factory->createValidator($schema, $this->uri));
    }

    public function testCreateValidatorWithExternalReference(): void
    {
        $uri = new Uri('https://example.com/a');

        $loader = $this->createMock(SchemaLoader::class);
        $loader
            ->expects($this->once())
            ->method('load')
            ->willReturn(new SchemaLoaderResult((object)[]));

        $factory = new ValidatorFactory([$loader]);
        $schema = (object)['$ref' => 'a'];
        $keywordValidator = new RefKeywordValidator($uri);
        $schemaValidator1 = new ObjectSchemaValidator($this->uri, $this->pointer, [$keywordValidator]);
        $schemaValidator2 = new ObjectSchemaValidator($uri, $this->pointer, []);
        $expected = new Validator($schemaValidator1, [(string)$uri => $schemaValidator2], []);

        $this->assertEquals($expected, $factory->createValidator($schema, $this->uri));
    }

    public function testCreateValidatorWithUnresolvableReference(): void
    {
        $schema = (object)['$ref' => 'a'];

        $this->expectException(ValidatorFactoryException::class);

        $this->factory->createValidator($schema, $this->uri);
    }

    public function testCreateValidatorWithInvalidExternalSchema(): void
    {
        $loader = $this->createMock(SchemaLoader::class);
        $loader
            ->expects($this->once())
            ->method('load')
            ->willThrowException(new SchemaLoaderException());

        $factory = new ValidatorFactory([$loader]);
        $schema = (object)['$ref' => 'a'];

        $this->expectException(ValidatorFactoryException::class);

        $factory->createValidator($schema, $this->uri);
    }

    public function testCreateValidatorWithUnusedSubschema(): void
    {
        $schema = (object)['$defs' => (object)['a' => (object)[]]];
        $expected = new Validator(new ObjectSchemaValidator($this->uri, $this->pointer, []), [], []);

        $this->assertEquals($expected, $this->factory->createValidator($schema, $this->uri));
    }

    public function testCreateValidatorWithBooleanSchema(): void
    {
        $expected = new Validator(new BooleanSchemaValidator($this->uri, $this->pointer, true), [], []);

        $this->assertEquals($expected, $this->factory->createValidator(true, $this->uri));
    }

    public function testCreateValidatorWithInvalidSchema(): void
    {
        $this->expectException(ValidatorFactoryException::class);

        $this->factory->createValidator(null, $this->uri);
    }
}
