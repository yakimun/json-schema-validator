<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\SchemaValidator;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class ObjectSchemaValidator implements SchemaValidator
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var list<KeywordHandler>
     */
    private $keywordHandlers;

    /**
     * @param string $absoluteLocation
     * @param list<KeywordHandler> $keywordHandlers
     */
    public function __construct(string $absoluteLocation, array $keywordHandlers)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->keywordHandlers = $keywordHandlers;
    }
}
