<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\MetaDataVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\DescriptionKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\DescriptionKeywordValidator
 */
final class DescriptionKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = DescriptionKeywordValidator::class;

        $this->assertInstanceOf($expected, new DescriptionKeywordValidator('a'));
    }
}
