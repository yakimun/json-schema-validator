<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ApplicatorVocabulary;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\AllOfKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\AllOfKeywordHandler
 */
final class AllOfKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new AllOfKeywordHandler([]);

        $this->assertInstanceOf(AllOfKeywordHandler::class, $keywordHandler);
    }
}
