<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\JsonLoader;

use GuzzleHttp\Psr7\LazyOpenStream;
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
        $loader = new StreamJsonLoader(new LazyOpenStream($this->filename, 'r'));

        return $loader->load();
    }
}
