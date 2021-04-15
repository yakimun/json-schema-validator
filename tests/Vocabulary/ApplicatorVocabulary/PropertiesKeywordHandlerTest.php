<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ApplicatorVocabulary;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\PropertiesKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\PropertiesKeywordHandler
 */
final class PropertiesKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new PropertiesKeywordHandler([]);

        $this->assertInstanceOf(PropertiesKeywordHandler::class, $keywordHandler);
    }
}
