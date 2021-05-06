<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\CoreVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordHandler\RefKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordHandler\RefKeywordHandler
 */
final class RefKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new RefKeywordHandler('https://example.com#/$ref', 'https://example.com');

        $this->assertInstanceOf(RefKeywordHandler::class, $keywordHandler);
    }
}
