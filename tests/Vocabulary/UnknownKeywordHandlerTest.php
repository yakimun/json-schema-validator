<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Vocabulary\UnknownKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\UnknownKeywordHandler
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 */
final class UnknownKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new UnknownKeywordHandler('https://example.com#/foo', 'foo', new JsonNull());

        $this->assertInstanceOf(UnknownKeywordHandler::class, $keywordHandler);
    }
}
