<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class DescriptionKeywordValidator implements KeywordValidator
{
    /**
     * @var string
     */
    private string $description;

    /**
     * @param string $description
     */
    public function __construct(string $description)
    {
        $this->description = $description;
    }
}
