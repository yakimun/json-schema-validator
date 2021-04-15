<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ApplicatorVocabulary;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\PatternPropertiesKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\PatternPropertiesKeywordHandler
 */
final class PatternPropertiesKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new PatternPropertiesKeywordHandler([]);

        $this->assertInstanceOf(PatternPropertiesKeywordHandler::class, $keywordHandler);
    }
}
