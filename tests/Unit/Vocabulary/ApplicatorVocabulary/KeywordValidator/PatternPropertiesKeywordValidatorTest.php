<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ApplicatorVocabulary\KeywordValidator;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\PatternPropertiesKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\PatternPropertiesKeywordValidator
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 */
final class PatternPropertiesKeywordValidatorTest extends TestCase
{
    public function testGetSchemaValidators(): void
    {
        $expected = ['/a/' => new ObjectSchemaValidator(new Uri('https://example.com'), new JsonPointer([]), [])];
        $validator = new PatternPropertiesKeywordValidator($expected);

        $this->assertSame($expected, $validator->getSchemaValidators());
    }
}
