<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\MetaDataVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\ExamplesKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\ExamplesKeywordValidator
 */
final class ExamplesKeywordValidatorTest extends TestCase
{
    public function testGetExamples(): void
    {
        $expected = [new JsonNull()];
        $validator = new ExamplesKeywordValidator($expected);

        $this->assertSame($expected, $validator->getExamples());
    }
}
