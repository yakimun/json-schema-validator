<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ApplicatorVocabulary\KeywordHandler;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\IfElseKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\IfElseKeywordHandler
 */
final class IfElseKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $absoluteLocation = 'https://example.com#/if';
        $schemaValidator = $this->createStub(SchemaValidator::class);
        $elseAbsoluteLocation = 'https://example.com#/else';
        $elseSchemaValidator = $this->createStub(SchemaValidator::class);
        $keywordHandler = new IfElseKeywordHandler(
            $absoluteLocation,
            $schemaValidator,
            $elseAbsoluteLocation,
            $elseSchemaValidator,
        );

        $this->assertInstanceOf(IfElseKeywordHandler::class, $keywordHandler);
    }
}
