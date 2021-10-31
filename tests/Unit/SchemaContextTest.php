<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Exception\SchemaException;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\ProcessedSchema;
use Yakimun\JsonSchemaValidator\SchemaAnchor;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaProcessor;
use Yakimun\JsonSchemaValidator\SchemaReference;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\SchemaAnchor
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\SchemaReference
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 */
final class SchemaContextTest extends TestCase
{
    /**
     * @var UriInterface
     */
    private UriInterface $uri;

    /**
     * @var UriInterface
     */
    private UriInterface $nonCanonicalUri;

    /**
     * @var non-empty-array<string, null> $properties
     */
    private array $properties;

    /**
     * @var JsonPointer
     */
    private JsonPointer $pointer;

    /**
     * @var SchemaIdentifier
     */
    private SchemaIdentifier $identifier;

    /**
     * @var SchemaIdentifier
     */
    private SchemaIdentifier $nonCanonicalIdentifier;

    /**
     * @var SchemaContext
     */
    private SchemaContext $context;

    protected function setUp(): void
    {
        $keywordName = 'a';

        $this->uri = new Uri('https://example1.com');
        $this->nonCanonicalUri = new Uri('https://example2.com');
        $this->properties = [$keywordName => null];
        $this->pointer = new JsonPointer();
        $this->identifier = new SchemaIdentifier($this->uri, $this->pointer, $this->pointer);
        $this->nonCanonicalIdentifier = new SchemaIdentifier($this->nonCanonicalUri, $this->pointer, $this->pointer);
        $this->context = new SchemaContext(
            new SchemaProcessor([$keywordName => $this->createStub(Keyword::class)]),
            $this->properties,
            $this->pointer,
            $this->identifier,
            [$this->nonCanonicalIdentifier],
        );
    }

    public function testGetProperties(): void
    {
        $expected = $this->properties;

        $this->assertSame($expected, $this->context->getProperties());
    }

    public function testGetPath(): void
    {
        $expected = $this->pointer;

        $this->assertSame($expected, $this->context->getPath());
    }

    public function testGetIdentifier(): void
    {
        $expected = $this->identifier;

        $this->assertSame($expected, $this->context->getIdentifier());
    }

    public function testSetIdentifier(): void
    {
        $uri = new Uri('https://example1.org');
        $token = 'a';
        $expectedIdentifier = new SchemaIdentifier($uri, $this->pointer, $this->pointer->addTokens($token));
        $expectedNonCanonicalIdentifiers = [$this->nonCanonicalIdentifier, $this->identifier];
        $this->context->setIdentifier($uri, $token);

        $this->assertEquals($expectedIdentifier, $this->context->getIdentifier());
        $this->assertSame($expectedNonCanonicalIdentifiers, $this->context->getNonCanonicalIdentifiers());
    }

    public function testSetIdentifierWithCurrentUri(): void
    {
        $token = 'a';
        $expectedIdentifier = new SchemaIdentifier($this->uri, $this->pointer, $this->pointer->addTokens($token));
        $expectedNonCanonicalIdentifiers = [$this->nonCanonicalIdentifier];
        $this->context->setIdentifier($this->uri, $token);

        $this->assertEquals($expectedIdentifier, $this->context->getIdentifier());
        $this->assertSame($expectedNonCanonicalIdentifiers, $this->context->getNonCanonicalIdentifiers());
    }

    public function testGetNonCanonicalIdentifiers(): void
    {
        $expected = [$this->nonCanonicalIdentifier];

        $this->assertSame($expected, $this->context->getNonCanonicalIdentifiers());
    }

    public function testGetAnchors(): void
    {
        $this->assertEmpty($this->context->getAnchors());
    }

    public function testAddAnchor(): void
    {
        $uri = $this->uri->withFragment('a');
        $dynamic = true;
        $token = 'a';
        $expected = [new SchemaAnchor($uri, $dynamic, $this->pointer->addTokens($token))];
        $this->context->addAnchor($uri, $dynamic, $token);

        $this->assertEquals($expected, $this->context->getAnchors());
    }

    public function testGetReferences(): void
    {
        $this->assertEmpty($this->context->getReferences());
    }

    public function testAddReference(): void
    {
        $token = 'a';
        $expected = [new SchemaReference($this->uri, $this->pointer->addTokens($token))];
        $this->context->addReference($this->uri, $token);

        $this->assertEquals($expected, $this->context->getReferences());
    }

    public function testGetKeywordValidators(): void
    {
        $this->assertEmpty($this->context->getKeywordValidators());
    }

    public function testAddKeywordValidator(): void
    {
        $validator = $this->createStub(KeywordValidator::class);
        $expected = [$validator];
        $this->context->addKeywordValidator($validator);

        $this->assertEquals($expected, $this->context->getKeywordValidators());
    }

    public function testGetProcessedSchemas(): void
    {
        $this->assertEmpty($this->context->getProcessedSchemas());
    }

    public function testCreateValidator(): void
    {
        $token = 'a';
        $pointer = $this->pointer->addTokens($token);
        $identifier = new SchemaIdentifier($this->uri, $pointer, $pointer);
        $nonCanonicalIdentifier = new SchemaIdentifier($this->nonCanonicalUri, $pointer, $pointer);
        $expectedValidator = new ObjectSchemaValidator($this->uri, $pointer, []);
        $processedSchema = new ProcessedSchema($expectedValidator, $identifier, [$nonCanonicalIdentifier], [], []);
        $expectedProcessedSchemas = [$processedSchema];

        $this->assertEquals($expectedValidator, $this->context->createValidator((object)[], $token));
        $this->assertEquals($expectedProcessedSchemas, $this->context->getProcessedSchemas());
    }

    public function testCreateException(): void
    {
        $message = 'a';
        $token = 'b';
        $expected = new SchemaException(sprintf('%s Path: "/%s".', $message, $token));

        $this->assertEquals($expected, $this->context->createException($message, $token));
    }
}
