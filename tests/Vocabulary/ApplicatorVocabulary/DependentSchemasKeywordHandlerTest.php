<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ApplicatorVocabulary;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\DependentSchemasKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\DependentSchemasKeywordHandler
 */
final class DependentSchemasKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new DependentSchemasKeywordHandler([]);

        $this->assertInstanceOf(DependentSchemasKeywordHandler::class, $keywordHandler);
    }
}
