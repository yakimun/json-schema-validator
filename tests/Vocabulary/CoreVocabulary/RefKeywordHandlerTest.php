<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\CoreVocabulary;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\RefKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\RefKeywordHandler
 */
final class RefKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new RefKeywordHandler(new Uri('https://example.com'));

        $this->assertInstanceOf(RefKeywordHandler::class, $keywordHandler);
    }
}
