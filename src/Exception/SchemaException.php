<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Exception;

use Yakimun\JsonSchemaValidator\JsonPointer;

final class SchemaException extends \RuntimeException implements ValidatorException
{
    /**
     * @var JsonPointer
     */
    private JsonPointer $path;

    /**
     * @param string $message
     * @param JsonPointer $path
     */
    public function __construct(string $message, JsonPointer $path)
    {
        parent::__construct($message);

        $this->path = $path;
    }

    /**
     * @return JsonPointer
     */
    public function getPath(): JsonPointer
    {
        return $this->path;
    }
}
