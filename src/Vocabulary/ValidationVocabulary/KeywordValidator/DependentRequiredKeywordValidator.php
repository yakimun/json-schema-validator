<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class DependentRequiredKeywordValidator implements KeywordValidator
{
    /**
     * @var array<string, list<string>>
     */
    private array $dependentRequiredProperties;

    /**
     * @param array<string, list<string>> $dependentRequiredProperties
     */
    public function __construct(array $dependentRequiredProperties)
    {
        $this->dependentRequiredProperties = $dependentRequiredProperties;
    }
}
