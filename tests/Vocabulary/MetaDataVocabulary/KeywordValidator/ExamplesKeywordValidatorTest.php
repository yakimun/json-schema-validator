<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\MetaDataVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\ExamplesKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\ExamplesKeywordValidator
 */
final class ExamplesKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = ExamplesKeywordValidator::class;

        $this->assertInstanceOf($expected, new ExamplesKeywordValidator([null]));
    }
}
