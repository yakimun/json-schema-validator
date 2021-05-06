<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\CoreVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordHandler\DynamicAnchorKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordHandler\DynamicAnchorKeywordHandler
 */
final class DynamicAnchorKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new DynamicAnchorKeywordHandler('https://example.com#/$dynamicAnchor', 'a');

        $this->assertInstanceOf(DynamicAnchorKeywordHandler::class, $keywordHandler);
    }
}
