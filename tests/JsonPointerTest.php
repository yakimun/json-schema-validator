<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\JsonPointer;

/**
 * @covers \Yakimun\JsonSchemaValidator\JsonPointer
 */
final class JsonPointerTest extends TestCase
{
    /**
     * @param list<string> $initialTokens
     * @param list<string> $tokens
     * @dataProvider tokenProvider
     */
    public function testAddTokens(array $initialTokens, array $tokens): void
    {
        $pointer = new JsonPointer(...$initialTokens);
        $expectedPointer = new JsonPointer(...$initialTokens, ...$tokens);
        $expectedInitialPointer = clone $pointer;

        $this->assertEquals($expectedPointer, $pointer->addTokens(...$tokens));
        $this->assertEquals($expectedInitialPointer, $pointer);
    }

    /**
     * @return non-empty-list<array{list<string>, list<string>}>
     */
    public function tokenProvider(): array
    {
        return [
            [[], []],
            [['a'], []],
            [['a', 'b'], []],
            [[], ['a']],
            [[], ['a', 'b']],
            [['a'], ['b']],
            [['a', 'b'], ['c']],
            [['a'], ['b', 'c']],
            [['a', 'b'], ['c', 'd']],
        ];
    }

    /**
     * @param list<string> $tokens
     * @dataProvider emptinessCheckTokenProvider
     */
    public function testIsEmpty(array $tokens): void
    {
        $pointer = new JsonPointer(...$tokens);
        $expected = empty($tokens);

        $this->assertSame($expected, $pointer->isEmpty());
    }

    /**
     * @return non-empty-list<array{list<string>}>
     */
    public function emptinessCheckTokenProvider(): array
    {
        return [
            [[]],
            [['a']],
        ];
    }

    /**
     * @param list<string> $tokens
     * @param string $expected
     * @dataProvider tokenWithStringProvider
     */
    public function testToString(array $tokens, string $expected): void
    {
        $this->assertSame($expected, (string)new JsonPointer(...$tokens));
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
