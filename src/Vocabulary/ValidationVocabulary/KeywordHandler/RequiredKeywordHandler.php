<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class RequiredKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var list<string>
     */
    private $requiredProperties;

    /**
     * @param string $absoluteLocation
     * @param list<string> $requiredProperties
     */
    public function __construct(string $absoluteLocation, array $requiredProperties)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->requiredProperties = $requiredProperties;
    }
}
