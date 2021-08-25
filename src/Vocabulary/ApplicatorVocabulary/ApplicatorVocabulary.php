<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary;

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
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\Vocabulary;

/**
 * @psalm-immutable
 */
final class ApplicatorVocabulary implements Vocabulary
{
    /**
     * @var non-empty-array<string, Keyword>
     */
    private array $keywords;

    public function __construct()
    {
        $this->keywords = [
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
    }

    /**
     * @return non-empty-array<string, Keyword>
     */
    public function getKeywords(): array
    {
        return $this->keywords;
    }
}
