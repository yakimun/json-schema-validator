<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\MetaDataVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\DeprecatedKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\DeprecatedKeywordValidator
 */
final class DeprecatedKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = DeprecatedKeywordValidator::class;

        $this->assertInstanceOf($expected, new DeprecatedKeywordValidator(true));
    }
}
