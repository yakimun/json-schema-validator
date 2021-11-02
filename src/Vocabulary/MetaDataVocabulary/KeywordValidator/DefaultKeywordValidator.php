<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class DefaultKeywordValidator implements KeywordValidator
{
    /**
     * @var list<mixed>|null|object|scalar
     */
    private $default;

    /**
     * @param list<mixed>|null|object|scalar $default
     */
    public function __construct($default)
    {
        $this->default = $default;
    }

    /**
     * @return list<mixed>|null|object|scalar
     */
    public function getDefault()
    {
        return $this->default;
    }
}
