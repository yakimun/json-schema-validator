<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ApplicatorVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\IfThenElseKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\IfThenElseKeywordHandler
 */
final class IfThenElseKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $absoluteLocation = 'https://example.com#/if';
        $schemaValidator = $this->createStub(SchemaValidator::class);
        $thenAbsoluteLocation = 'https://example.com#/then';
        $thenSchemaValidator = $this->createStub(SchemaValidator::class);
        $elseAbsoluteLocation = 'https://example.com#/else';
        $elseSchemaValidator = $this->createStub(SchemaValidator::class);
        $keywordHandler = new IfThenElseKeywordHandler(
            $absoluteLocation,
            $schemaValidator,
            $thenAbsoluteLocation,
            $thenSchemaValidator,
            $elseAbsoluteLocation,
            $elseSchemaValidator,
        );

        $this->assertInstanceOf(IfThenElseKeywordHandler::class, $keywordHandler);
    }
}
