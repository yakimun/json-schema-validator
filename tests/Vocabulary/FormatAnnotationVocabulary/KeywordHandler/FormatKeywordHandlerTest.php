<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\FormatAnnotationVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\FormatAnnotationVocabulary\KeywordHandler\FormatKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\FormatAnnotationVocabulary\KeywordHandler\FormatKeywordHandler
 */
final class FormatKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new FormatKeywordHandler('https://example.com/#format', 'a');

        $this->assertInstanceOf(FormatKeywordHandler::class, $keywordHandler);
    }
}
