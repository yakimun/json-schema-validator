<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ApplicatorVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\IfThenKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\IfThenKeywordHandler
 */
final class IfThenKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $absoluteLocation = 'https://example.com#/if';
        $schemaValidator = $this->createStub(SchemaValidator::class);
        $thenAbsoluteLocation = 'https://example.com#/then';
        $thenSchemaValidator = $this->createStub(SchemaValidator::class);
        $keywordHandler = new IfThenKeywordHandler(
            $absoluteLocation,
            $schemaValidator,
            $thenAbsoluteLocation,
            $thenSchemaValidator,
        );

        $this->assertInstanceOf(IfThenKeywordHandler::class, $keywordHandler);
    }
}
