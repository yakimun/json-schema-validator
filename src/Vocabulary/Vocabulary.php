<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary;

/**
 * @psalm-immutable
 */
interface Vocabulary
{
    /**
     * @return non-empty-list<Keyword>
     */
    public function getKeywords(): array;
}
