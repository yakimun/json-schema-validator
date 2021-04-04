<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\SchemaValidator;

use Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

final class ObjectSchemaValidator implements SchemaValidator
{
    /**
     * @var list<KeywordHandler>
     */
    private $keywordHandlers;

    /**
     * @var SchemaIdentifier
     */
    private $identifier;

    /**
     * @param list<KeywordHandler> $keywordHandlers
     * @param SchemaIdentifier $identifier
     */
    public function __construct(array $keywordHandlers, SchemaIdentifier $identifier)
    {
        $this->keywordHandlers = $keywordHandlers;
        $this->identifier = $identifier;
    }
}