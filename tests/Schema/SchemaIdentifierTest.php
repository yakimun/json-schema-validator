<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Schema;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonPointer;
use Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier;

/**
 * @covers \Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonPointer
 */
final class SchemaIdentifierTest extends TestCase
{
    /**
     * @var SchemaIdentifier
     */
    private $identifier;

    protected function setUp(): void
    {
        $this->identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer('a'));
    }

    public function testGetUri(): void
    {
        $this->assertEquals(new Uri('https://example.com'), $this->identifier->getUri());
    }

    public function testGetFragment(): void
    {
        $this->assertEquals(new JsonPointer('a'), $this->identifier->getFragment());
    }
}
