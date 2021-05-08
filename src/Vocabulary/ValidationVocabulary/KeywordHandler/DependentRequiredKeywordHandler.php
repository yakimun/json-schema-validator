<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class DependentRequiredKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var array<string, list<string>>
     */
    private $dependentRequiredProperties;

    /**
     * @param string $absoluteLocation
     * @param array<string, list<string>> $dependentRequiredProperties
     */
    public function __construct(string $absoluteLocation, array $dependentRequiredProperties)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->dependentRequiredProperties = $dependentRequiredProperties;
    }
}
