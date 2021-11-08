<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ApplicatorVocabulary\KeywordValidator;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\AllOfKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\AllOfKeywordValidator
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 */
final class AllOfKeywordValidatorTest extends TestCase
{
    public function testGetSchemaValidators(): void
    {
        $expected = [new ObjectSchemaValidator(new Uri('https://example.com'), new JsonPointer([]), [])];
        $validator = new AllOfKeywordValidator($expected);

        $this->assertSame($expected, $validator->getSchemaValidators());
    }
}
