<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\MetaDataVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\DefaultKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\DefaultKeywordValidator
 */
final class DefaultKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = DefaultKeywordValidator::class;

        $this->assertInstanceOf($expected, new DefaultKeywordValidator(null));
    }
}
