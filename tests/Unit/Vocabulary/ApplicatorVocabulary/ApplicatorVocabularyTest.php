<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ApplicatorVocabulary;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\ApplicatorVocabulary;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\AdditionalPropertiesKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\AllOfKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\AnyOfKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\ContainsKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\DependentSchemasKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\ElseKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\IfKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\ItemsKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\NotKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\OneOfKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\PrefixItemsKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\PropertiesKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\PropertyNamesKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\ThenKeyword;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\ApplicatorVocabulary
 */
final class ApplicatorVocabularyTest extends TestCase
{
    public function testGetKeywords(): void
    {
        $vocabulary = new ApplicatorVocabulary();
        $expected = [
            AllOfKeyword::NAME => new AllOfKeyword(),
            AnyOfKeyword::NAME => new AnyOfKeyword(),
            OneOfKeyword::NAME => new OneOfKeyword(),
            NotKeyword::NAME => new NotKeyword(),
            IfKeyword::NAME => new IfKeyword(),
            ThenKeyword::NAME => new ThenKeyword(),
            ElseKeyword::NAME => new ElseKeyword(),
            DependentSchemasKeyword::NAME => new DependentSchemasKeyword(),
            PrefixItemsKeyword::NAME => new PrefixItemsKeyword(),
            ItemsKeyword::NAME => new ItemsKeyword(),
            ContainsKeyword::NAME => new ContainsKeyword(),
            PropertiesKeyword::NAME => new PropertiesKeyword(),
            AdditionalPropertiesKeyword::NAME => new AdditionalPropertiesKeyword(),
            PropertyNamesKeyword::NAME => new PropertyNamesKeyword(),
        ];

        $this->assertEquals($expected, $vocabulary->getKeywords());
    }
}
