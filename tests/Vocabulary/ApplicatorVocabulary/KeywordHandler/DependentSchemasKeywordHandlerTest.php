<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ApplicatorVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\DependentSchemasKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\DependentSchemasKeywordHandler
 */
final class DependentSchemasKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new DependentSchemasKeywordHandler('https://example.com#/dependentSchemas', []);

        $this->assertInstanceOf(DependentSchemasKeywordHandler::class, $keywordHandler);
    }
}
