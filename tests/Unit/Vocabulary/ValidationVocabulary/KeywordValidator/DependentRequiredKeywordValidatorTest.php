<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\DependentRequiredKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\DependentRequiredKeywordValidator
 */
final class DependentRequiredKeywordValidatorTest extends TestCase
{
    /**
     * @var string
     */
    private string $key;

    /**
     * @var list<string>
     */
    private array $properties;

    /**
     * @var DependentRequiredKeywordValidator
     */
    private DependentRequiredKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->key = 'a';
        $this->properties = ['b'];
        $this->validator = new DependentRequiredKeywordValidator([$this->key => $this->properties]);
    }

    public function testGetDependentRequiredProperties(): void
    {
        $expected = [$this->key => $this->properties];

        $this->assertSame($expected, $this->validator->getDependentRequiredProperties());
    }
}
