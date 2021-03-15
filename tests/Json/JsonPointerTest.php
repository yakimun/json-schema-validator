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
     * @param string[] $tokens
     * @param string $expected
     *
     * @dataProvider tokenProvider
     */
    public function testConstructor(array $tokens, string $expected): void
    {
        $this->assertEquals($expected, new JsonPointer(...$tokens));
    }

    /**
     * @param string[] $tokens
     * @param string $expected
     *
     * @dataProvider tokenProvider
     */
    public function testAddToken(array $tokens, string $expected): void
    {
        $jsonPointer = new JsonPointer();

        $modifiedJsonPointer = $jsonPointer;
        foreach ($tokens as $token) {
            $modifiedJsonPointer = $modifiedJsonPointer->addToken($token);
        }

        $this->assertEquals($expected, $modifiedJsonPointer);
        $this->assertEquals('', $jsonPointer);
    }

    /**
     * @param string[] $tokens
     * @param string $expected
     *
     * @dataProvider tokenProvider
     */
    public function testAddPointer(array $tokens, string $expected): void
    {
        $jsonPointer = new JsonPointer();

        $this->assertEquals($expected, $jsonPointer->addPointer(new JsonPointer(...$tokens)));
        $this->assertEquals('', $jsonPointer);
    }

    /**
     * @return mixed[][]
     */
    public function tokenProvider(): array
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
