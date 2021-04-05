<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Schema;

use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\UnknownKeywordHandler;

final class ObjectSchema implements Schema
{
    /**
     * @var array<string, JsonValue>
     * @readonly
     */
    private $properties;

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
     * @param array<string, JsonValue> $properties
     * @param SchemaIdentifier $identifier
     * @param SchemaFactory $factory
     * @param non-empty-array<string, Keyword> $keywords
     */
    public function __construct(
        array $properties,
        SchemaIdentifier $identifier,
        SchemaFactory $factory,
        array $keywords
    ) {
        $this->properties = $properties;
        $this->identifier = $identifier;
        $this->factory = $factory;
        $this->keywords = $keywords;
    }

    /**
     * @return non-empty-list<ProcessedSchema>
     */
    public function process(): array
    {
        if (!$this->properties) {
            return [new ProcessedSchema(new ObjectSchemaValidator([], $this->identifier), $this->identifier, [], [])];
        }

        $context = new SchemaContext($this->factory, $this->identifier);

        foreach (array_intersect_key($this->keywords, $this->properties) as $keyword) {
            $keyword->process($this->properties, $context);
        }

        foreach (array_diff_key($this->properties, $this->keywords) as $name => $value) {
            $context->addKeywordHandler(new UnknownKeywordHandler($name, $value));
        }

        $identifier = $context->getIdentifier();
        $anchors = $context->getAnchors();
        $references = $context->getReferences();

        $validator = new ObjectSchemaValidator($context->getKeywordHandlers(), $identifier);
        $processedSchema = new ProcessedSchema($validator, $identifier, $anchors, $references);

        return array_merge([$processedSchema], $context->getProcessedSchemas());
    }
}
