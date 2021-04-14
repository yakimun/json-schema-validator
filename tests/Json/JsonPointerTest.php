<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Json;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonPointer;

/**
 * @covers \Yakimun\JsonSchemaValidator\Json\JsonPointer
 */
final class JsonPointerTest extends TestCase
{
    /**
     * @param list<string> $initialTokens
     * @param list<string> $tokens
     * @param list<string> $expected
     *
     * @dataProvider tokenProvider
     */
    public function testAddTokens(array $initialTokens, array $tokens, array $expected): void
    {
        $jsonPointer = new JsonPointer(...$initialTokens);

        $this->assertEquals(new JsonPointer(...$expected), $jsonPointer->addTokens(...$tokens));
        $this->assertEquals(new JsonPointer(...$initialTokens), $jsonPointer);
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

    /**
     * @param list<string> $tokens1
     * @param list<string> $tokens2
     * @param bool $expected
     *
     * @dataProvider tokenWithEqualityProvider
     */
    public function testEquals(array $tokens1, array $tokens2, bool $expected): void
    {
        $pointer = new JsonPointer(...$tokens1);

        $this->assertEquals($expected, $pointer->equals(new JsonPointer(...$tokens2)));
    }

    /**
     * @return non-empty-list<array{list<string>, list<string>, bool}>
     */
    public function tokenWithEqualityProvider(): array
    {
        return [
            [[], [], true],
            [['a'], ['a'], true],
            [['a', 'b'], ['a', 'b'], true],
            [['a'], [], false],
            [[], ['a'], false],
            [['a'], ['b'], false],
            [['a'], ['a', 'b'], false],
            [['a', 'b'], ['a'], false],
            [['a', 'b'], ['b', 'a'], false],
        ];
    }

    /**
     * @param list<string> $tokens
     * @param string $expected
     *
     * @dataProvider tokenWithStringProvider
     */
    public function testToString(array $tokens, string $expected): void
    {
        $this->assertEquals($expected, new JsonPointer(...$tokens));
    }

    /**
     * @return non-empty-list<array{list<string>, string}>
     */
    public function tokenWithStringProvider(): array
    {
        return [
            [[], ''],
            [['a'], '/a'],
            [['a', 'b'], '/a/b'],
            [['~'], '/~0'],
            [['/'], '/~1'],
        ];
    }
}
