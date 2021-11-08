<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ApplicatorVocabulary\KeywordValidator;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\IfKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\IfKeywordValidator
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 */
final class IfKeywordValidatorTest extends TestCase
{
    public function testGetSchemaValidator(): void
    {
        $expected = new ObjectSchemaValidator(new Uri('https://example.com'), new JsonPointer([]), []);
        $validator = new IfKeywordValidator($expected);

        $this->assertSame($expected, $validator->getSchemaValidator());
    }
}
