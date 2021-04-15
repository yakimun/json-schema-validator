<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ApplicatorVocabulary;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\OneOfKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\OneOfKeywordHandler
 */
final class OneOfKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new OneOfKeywordHandler([]);

        $this->assertInstanceOf(OneOfKeywordHandler::class, $keywordHandler);
    }
}
