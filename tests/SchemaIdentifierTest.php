<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;

/**
 * @covers \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses   \Yakimun\JsonSchemaValidator\JsonPointer
 */
final class SchemaIdentifierTest extends TestCase
{
    /**
     * @var SchemaIdentifier
     */
    private $identifier;

    protected function setUp(): void
    {
        $this->identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer('a'));
    }

    public function testGetUri(): void
    {
        $this->assertEquals(new Uri('https://example.com'), $this->identifier->getUri());
    }

    public function testGetFragment(): void
    {
        $this->assertEquals(new JsonPointer('a'), $this->identifier->getFragment());
    }

    /**
     * @param list<string> $initialTokens
     * @param list<string> $tokens
     * @param list<string> $expected
     *
     * @dataProvider tokenProvider
     */
    public function testAddTokens(array $initialTokens, array $tokens, array $expected): void
    {
        $fragment = new JsonPointer(...$initialTokens);
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $fragment);
        $expectedIdentifier = new SchemaIdentifier(new Uri('https://example.com'), $fragment);
        $expectedNewIdentifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer(...$expected));

        $this->assertEquals($expectedNewIdentifier, $identifier->addTokens(...$tokens));
        $this->assertEquals($expectedIdentifier, $identifier);
    }

    /**
     * @return non-empty-list<array{list<string>, list<string>, list<string>}>
     */
    public function tokenProvider(): array
    {
        return [
            [[], [], []],
            [['a'], [], ['a']],
            [['a', 'b'], [], ['a', 'b']],
            [[], ['a'], ['a']],
            [[], ['a', 'b'], ['a', 'b']],
            [['a'], ['b'], ['a', 'b']],
            [['a', 'b'], ['c'], ['a', 'b', 'c']],
            [['a'], ['b', 'c'], ['a', 'b', 'c']],
            [['a', 'b'], ['c', 'd'], ['a', 'b', 'c', 'd']],
        ];
    }
}
