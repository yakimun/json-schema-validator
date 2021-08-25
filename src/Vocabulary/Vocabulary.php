<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary;

/**
 * @psalm-immutable
 */
interface Vocabulary
{
    /**
     * @return non-empty-array<string, Keyword>
     */
    public function getKeywords(): array;
}
