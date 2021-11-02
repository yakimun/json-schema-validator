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
     * @var list<mixed>|null|object|scalar
     */
    private $const;

    /**
     * @param list<mixed>|null|object|scalar $const
     */
    public function __construct($const)
    {
        $this->const = $const;
    }

    /**
     * @return list<mixed>|null|object|scalar
     */
    public function getConst()
    {
        return $this->const;
    }
}
