<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator;

use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class RefKeywordValidator implements KeywordValidator
{
    /**
     * @var UriInterface
     */
    private UriInterface $ref;

    /**
     * @param UriInterface $ref
     */
    public function __construct(UriInterface $ref)
    {
        $this->ref = $ref;
    }
}
