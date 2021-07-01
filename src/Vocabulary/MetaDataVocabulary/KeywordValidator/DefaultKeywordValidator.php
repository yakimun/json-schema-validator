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
     * @var mixed
     */
    private $default;

    /**
     * @param scalar|object|list<mixed>|null $default
     */
    public function __construct($default)
    {
        $this->default = $default;
    }
}
