<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class RequiredKeywordValidator implements KeywordValidator
{
    /**
     * @var list<string>
     */
    private array $requiredProperties;

    /**
     * @param list<string> $requiredProperties
     */
    public function __construct(array $requiredProperties)
    {
        $this->requiredProperties = $requiredProperties;
    }

    /**
     * @return list<string>
     */
    public function getRequiredProperties(): array
    {
        return $this->requiredProperties;
    }
}
