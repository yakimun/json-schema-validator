<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ApplicatorVocabulary;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\AnyOfKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\AnyOfKeywordHandler
 */
final class AnyOfKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new AnyOfKeywordHandler([]);

        $this->assertInstanceOf(AnyOfKeywordHandler::class, $keywordHandler);
    }
}
