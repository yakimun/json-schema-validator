<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\IfElseKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\IfKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\IfThenElseKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\IfThenKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

final class IfKeyword implements Keyword
{
    private const NAME = 'if';

    private const THEN_NAME = 'then';

    private const ELSE_NAME = 'else';

    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param JsonPointer $path
     * @param SchemaContext $context
     */
    public function process(array $properties, JsonPointer $path, SchemaContext $context): void
    {
        $keywordIdentifier = $context->getIdentifier()->addTokens(self::NAME);
        $keywordPath = $path->addTokens(self::NAME);

        $validator = $context->createValidator($properties[self::NAME], $keywordIdentifier, $keywordPath);

        $thenProperty = $properties[self::THEN_NAME] ?? null;

        if ($thenProperty) {
            $thenKeywordIdentifier = $context->getIdentifier()->addTokens(self::THEN_NAME);
            $thenKeywordPath = $path->addTokens(self::THEN_NAME);

            $thenValidator = $context->createValidator($thenProperty, $thenKeywordIdentifier, $thenKeywordPath);
        } else {
            $thenKeywordIdentifier = null;
            $thenValidator = null;
        }

        $elseProperty = $properties[self::ELSE_NAME] ?? null;

        if ($elseProperty) {
            $elseKeywordIdentifier = $context->getIdentifier()->addTokens(self::ELSE_NAME);
            $elseKeywordPath = $path->addTokens(self::ELSE_NAME);

            $elseValidator = $context->createValidator($elseProperty, $elseKeywordIdentifier, $elseKeywordPath);
        } else {
            $elseKeywordIdentifier = null;
            $elseValidator = null;
        }

        $context->addKeywordHandler($this->createKeywordHandler(
            $keywordIdentifier,
            $validator,
            $thenKeywordIdentifier,
            $thenValidator,
            $elseKeywordIdentifier,
            $elseValidator,
        ));
    }

    /**
     * @param SchemaIdentifier $identifier
     * @param SchemaValidator $validator
     * @param SchemaIdentifier|null $thenIdentifier
     * @param SchemaValidator|null $thenValidator
     * @param SchemaIdentifier|null $elseIdentifier
     * @param SchemaValidator|null $elseValidator
     * @return IfKeywordHandler|IfThenKeywordHandler|IfElseKeywordHandler|IfThenElseKeywordHandler
     */
    private function createKeywordHandler(
        SchemaIdentifier $identifier,
        SchemaValidator $validator,
        ?SchemaIdentifier $thenIdentifier,
        ?SchemaValidator $thenValidator,
        ?SchemaIdentifier $elseIdentifier,
        ?SchemaValidator $elseValidator
    ): KeywordHandler {
        if ($thenValidator && $elseValidator) {
            return new IfThenElseKeywordHandler(
                (string)$identifier,
                $validator,
                (string)$thenIdentifier,
                $thenValidator,
                (string)$elseIdentifier,
                $elseValidator,
            );
        }

        if ($thenValidator) {
            return new IfThenKeywordHandler((string)$identifier, $validator, (string)$thenIdentifier, $thenValidator);
        }

        if ($elseValidator) {
            return new IfElseKeywordHandler((string)$identifier, $validator, (string)$elseIdentifier, $elseValidator);
        }

        return new IfKeywordHandler((string)$identifier, $validator);
    }
}
