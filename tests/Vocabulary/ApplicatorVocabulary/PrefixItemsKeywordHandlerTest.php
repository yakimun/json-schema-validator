<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ApplicatorVocabulary;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\PrefixItemsKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\PrefixItemsKeywordHandler
 */
final class PrefixItemsKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new PrefixItemsKeywordHandler([]);

        $this->assertInstanceOf(PrefixItemsKeywordHandler::class, $keywordHandler);
    }
}
