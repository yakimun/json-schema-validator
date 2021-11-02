<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\SchemaValidator;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaValidator\BooleanSchemaValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\SchemaValidator\BooleanSchemaValidator
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 */
final class BooleanSchemaValidatorTest extends TestCase
{
    /**
     * @var UriInterface
     */
    private UriInterface $uri;

    /**
     * @var JsonPointer
     */
    private JsonPointer $fragment;

    /**
     * @var bool
     */
    private bool $value;

    /**
     * @var BooleanSchemaValidator
     */
    private BooleanSchemaValidator $validator;

    protected function setUp(): void
    {
        $this->uri = new Uri('https://example.com');
        $this->fragment = new JsonPointer();
        $this->value = true;
        $this->validator = new BooleanSchemaValidator($this->uri, $this->fragment, $this->value);
    }

    public function testGetUri(): void
    {
        $expected = $this->uri;

        $this->assertSame($expected, $this->validator->getUri());
    }

    public function testGetFragment(): void
    {
        $expected = $this->fragment;

        $this->assertSame($expected, $this->validator->getFragment());
    }

    public function testIsValue(): void
    {
        $expected = $this->value;

        $this->assertSame($expected, $this->validator->isValue());
    }
}
