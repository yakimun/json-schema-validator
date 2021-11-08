<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\JsonLoader;

use Yakimun\JsonSchemaValidator\Exception\JsonLoaderException;
use Yakimun\JsonSchemaValidator\Json\JsonValue;

final class FileJsonLoader implements JsonLoader
{
    /**
     * @var string
     * @readonly
     */
    private string $filename;

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
        $filename = realpath($this->filename);

        if (!$filename || !is_file($filename) || ($json = file_get_contents($filename)) === false) {
            throw new JsonLoaderException('The file must exist and be readable.');
        }

        $loader = new StringJsonLoader($json);

        return $loader->load();
    }
}
