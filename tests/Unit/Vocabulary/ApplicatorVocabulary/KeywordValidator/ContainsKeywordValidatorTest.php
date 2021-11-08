<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ApplicatorVocabulary\KeywordValidator;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\ContainsKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\ContainsKeywordValidator
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 */
final class ContainsKeywordValidatorTest extends TestCase
{
    public function testGetSchemaValidator(): void
    {
        $expected = new ObjectSchemaValidator(new Uri('https://example.com'), new JsonPointer([]), []);
        $validator = new ContainsKeywordValidator($expected);

        $this->assertSame($expected, $validator->getSchemaValidator());
    }
}
