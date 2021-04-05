<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Schema;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Json\JsonPointer;
use Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier;

/**
 * @covers \Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonPointer
 */
final class SchemaIdentifierTest extends TestCase
{
    /**
     * @var UriInterface
     */
    private $uri;

    /**
     * @var JsonPointer
     */
    private $jsonPointer;

    protected function setUp(): void
    {
        $this->uri = new Uri('https://example.com');
        $this->jsonPointer = new JsonPointer();
    }

    public function testGetUri(): void
    {
        $schemaIdentifier = new SchemaIdentifier($this->uri, $this->jsonPointer);

        $this->assertEquals($this->uri, $schemaIdentifier->getUri());
    }

    public function testGetFragment(): void
    {
        $schemaIdentifier = new SchemaIdentifier($this->uri, $this->jsonPointer);

        $this->assertEquals($this->jsonPointer, $schemaIdentifier->getFragment());
    }
}
