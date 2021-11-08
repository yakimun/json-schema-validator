<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\DependentRequiredKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\DependentRequiredKeywordValidator
 */
final class DependentRequiredKeywordValidatorTest extends TestCase
{
    public function testGetDependentRequiredProperties(): void
    {
        $expected = ['a' => ['b']];
        $validator = new DependentRequiredKeywordValidator($expected);

        $this->assertSame($expected, $validator->getDependentRequiredProperties());
    }
}
