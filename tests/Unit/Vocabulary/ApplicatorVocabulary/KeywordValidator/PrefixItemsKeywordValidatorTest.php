<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ApplicatorVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\PrefixItemsKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\PrefixItemsKeywordValidator
 */
final class PrefixItemsKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = PrefixItemsKeywordValidator::class;

        $this->assertInstanceOf($expected, new PrefixItemsKeywordValidator([]));
    }
}
