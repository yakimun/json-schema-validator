<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\JsonLoader;

use Yakimun\JsonSchemaValidator\Exception\InvalidValueException;
use Yakimun\JsonSchemaValidator\Json\JsonValue;

final class FileJsonLoader implements JsonLoader
{
    /**
     * @var string
     * @readonly
     */
    private $filename;

    /**
     * @param string $filename
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return JsonValue
     */
    public function load(): JsonValue
    {
        if (!is_readable($this->filename) || ($json = file_get_contents($this->filename)) === false) {
            $message = sprintf('The file must exist and be readable. Filename: "%s".', $this->filename);
            throw new InvalidValueException($message);
        }

        $loader = new StringJsonLoader($json);

        return $loader->load();
    }
}
