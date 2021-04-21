<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Schema;

use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\UnknownKeywordHandler;

final class ObjectSchema implements Schema
{
    /**
     * @var JsonObject
     * @readonly
     */
    private $value;

    /**
     * @var SchemaIdentifier
     * @readonly
     */
    private $identifier;

    /**
     * @var SchemaFactory
     * @readonly
     */
    private $factory;

    /**
     * @var non-empty-array<string, Keyword>
     * @readonly
     */
    private $keywords;

    /**
     * @param JsonObject $value
     * @param SchemaIdentifier $identifier
     * @param SchemaFactory $factory
     * @param non-empty-array<string, Keyword> $keywords
     */
    public function __construct(
        JsonObject $value,
        SchemaIdentifier $identifier,
        SchemaFactory $factory,
        array $keywords
    ) {
        $this->value = $value;
        $this->identifier = $identifier;
        $this->factory = $factory;
        $this->keywords = $keywords;
    }

    /**
     * @return non-empty-list<ProcessedSchema>
     */
    public function process(): array
    {
        $properties = $this->value->getProperties();
        $path = $this->value->getPath();

        if (!$properties) {
            $validator = new ObjectSchemaValidator([], $this->identifier);

            return [new ProcessedSchema($validator, $this->identifier, [], [], $path)];
        }

        $context = new SchemaContext($this->factory, $this->identifier);

        foreach (array_intersect_key($this->keywords, $properties) as $keyword) {
            $keyword->process($properties, $context);
        }

        foreach (array_diff_key($properties, $this->keywords) as $name => $value) {
            $context->addKeywordHandler(new UnknownKeywordHandler($name, $value));
        }

        $identifier = $context->getIdentifier();
        $anchors = $context->getAnchors();
        $references = $context->getReferences();

        $validator = new ObjectSchemaValidator($context->getKeywordHandlers(), $identifier);
        $processedSchema = new ProcessedSchema($validator, $identifier, $anchors, $references, $path);

        return array_merge([$processedSchema], $context->getProcessedSchemas());
    }
}
