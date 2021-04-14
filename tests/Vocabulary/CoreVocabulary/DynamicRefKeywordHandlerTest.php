<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\CoreVocabulary;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\DynamicRefKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\DynamicRefKeywordHandler
 */
final class DynamicRefKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new DynamicRefKeywordHandler(new Uri('https://example.com'));

        $this->assertInstanceOf(DynamicRefKeywordHandler::class, $keywordHandler);
    }
}
