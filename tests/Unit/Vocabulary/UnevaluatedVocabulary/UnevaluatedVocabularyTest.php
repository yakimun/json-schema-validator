<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\UnevaluatedVocabulary;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\Keyword\UnevaluatedItemsKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\Keyword\UnevaluatedPropertiesKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\UnevaluatedVocabulary;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\UnevaluatedVocabulary
 */
final class UnevaluatedVocabularyTest extends TestCase
{
    public function testGetKeywords(): void
    {
        $vocabulary = new UnevaluatedVocabulary();
        $expected = [
            new UnevaluatedItemsKeyword(),
            new UnevaluatedPropertiesKeyword(),
        ];

        $this->assertEquals($expected, $vocabulary->getKeywords());
    }
}
