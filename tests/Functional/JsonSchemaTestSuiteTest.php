<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Functional;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\JsonLoader\MixedJsonLoader;
use Yakimun\JsonSchemaValidator\SchemaFinder\DirectorySchemaFinder;
use Yakimun\JsonSchemaValidator\Validator;
use Yakimun\JsonSchemaValidator\ValidatorFactory;

/**
 * @coversNothing
 */
final class JsonSchemaTestSuiteTest extends TestCase
{
    /**
     * @param object|bool $schema
     * @dataProvider valueProvider
     */
    public function testCreateValidator($schema): void
    {
        $schemaUri = new Uri('https://json-schema.org/draft/2020-12/');
        $remotesUri = new Uri('http://localhost:1234/');

        $schemaDirectory = __DIR__ . '/../../schema/';
        $remotesDirectory = __DIR__ . '/../../JSON-Schema-Test-Suite/remotes/';

        $schemaDirectoryLoader = new DirectorySchemaFinder($schemaUri, $schemaDirectory);
        $remotesDirectoryLoader = new DirectorySchemaFinder($remotesUri, $remotesDirectory);

        $factory = new ValidatorFactory([$schemaDirectoryLoader, $remotesDirectoryLoader]);
        $validator = $factory->createValidator(new MixedJsonLoader($schema), new Uri('https://example.com'));

        $expected = Validator::class;

        $this->assertInstanceOf($expected, $validator);
    }

    /**
     * @return array<string, array{object|bool}>
     * @throws \JsonException
     */
    public function valueProvider(): array
    {
        $directory = __DIR__ . '/../../JSON-Schema-Test-Suite/tests/draft2020-12/';

        $filenames = scandir($directory);

        if ($filenames === false) {
            throw new \RuntimeException('Tests directory must exist and be readable.');
        }

        $datasets = [];

        foreach ($filenames as $filename) {
            $path = $directory . $filename;

            if (!is_file($path)) {
                continue;
            }

            $json = file_get_contents($path);

            if ($json === false) {
                throw new \RuntimeException('Test file must be readable.');
            }

            /**
             * @var list<\stdClass> $testCases
             */
            $testCases = json_decode($json, false, 512, JSON_THROW_ON_ERROR);

            foreach ($testCases as $testCase) {
                /**
                 * @var string $description
                 */
                $description = $testCase->description;

                /**
                 * @var object|bool $schema
                 */
                $schema = $testCase->schema;

                $datasets[$description] = [$schema];
            }
        }

        return $datasets;
    }
}
