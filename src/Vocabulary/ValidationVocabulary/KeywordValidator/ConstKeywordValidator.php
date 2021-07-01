<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class ConstKeywordValidator implements KeywordValidator
{
    /**
     * @var mixed
     */
    private $const;

    /**
     * @param scalar|object|list<mixed>|null $const
     */
    public function __construct($const)
    {
        $this->const = $const;
    }
}
