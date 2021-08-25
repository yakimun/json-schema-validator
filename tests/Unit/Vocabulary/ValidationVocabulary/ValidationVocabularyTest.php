<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\ConstKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\DependentRequiredKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\EnumKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\ExclusiveMaximumKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\ExclusiveMinimumKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\MaxContainsKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\MaximumKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\MaxItemsKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\MaxLengthKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\MaxPropertiesKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\MinContainsKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\MinimumKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\MinItemsKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\MinLengthKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\MinPropertiesKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\MultipleOfKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\PatternKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\RequiredKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\TypeKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\UniqueItemsKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\ValidationVocabulary;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\ValidationVocabulary
 */
final class ValidationVocabularyTest extends TestCase
{
    public function testGetKeywords(): void
    {
        $vocabulary = new ValidationVocabulary();
        $expected = [
            TypeKeyword::NAME => new TypeKeyword(),
            EnumKeyword::NAME => new EnumKeyword(),
            ConstKeyword::NAME => new ConstKeyword(),
            MultipleOfKeyword::NAME => new MultipleOfKeyword(),
            MaximumKeyword::NAME => new MaximumKeyword(),
            ExclusiveMaximumKeyword::NAME => new ExclusiveMaximumKeyword(),
            MinimumKeyword::NAME => new MinimumKeyword(),
            ExclusiveMinimumKeyword::NAME => new ExclusiveMinimumKeyword(),
            MaxLengthKeyword::NAME => new MaxLengthKeyword(),
            MinLengthKeyword::NAME => new MinLengthKeyword(),
            PatternKeyword::NAME => new PatternKeyword(),
            MaxItemsKeyword::NAME => new MaxItemsKeyword(),
            MinItemsKeyword::NAME => new MinItemsKeyword(),
            UniqueItemsKeyword::NAME => new UniqueItemsKeyword(),
            MaxContainsKeyword::NAME => new MaxContainsKeyword(),
            MinContainsKeyword::NAME => new MinContainsKeyword(),
            MaxPropertiesKeyword::NAME => new MaxPropertiesKeyword(),
            MinPropertiesKeyword::NAME => new MinPropertiesKeyword(),
            RequiredKeyword::NAME => new RequiredKeyword(),
            DependentRequiredKeyword::NAME => new DependentRequiredKeyword(),
        ];

        $this->assertEquals($expected, $vocabulary->getKeywords());
    }
}
