<?php

namespace App\Service;

use Ergebnis\Json\Json;
use Ergebnis\Json\Pointer\JsonPointer;
use Ergebnis\Json\SchemaValidator\SchemaValidator as JsonSchemaValidator;
use function is_array;
use function is_string;
use const JSON_ERROR_NONE;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final class SchemaValidator
{
    public function __construct(
        private readonly ParameterBagInterface $parameterBag
    ) {
    }

    public function validate(string $schemaName, array|string $data): bool
    {
        if (!$this->jsonIsValidated($data) || false === $schema = $this->getSchema($schemaName)) {
            return false;
        }

        $jsonSchemaValidator = new JsonSchemaValidator();
        $dataInJson = Json::fromString(is_array($data) ? json_encode($data) : $data);

        return $jsonSchemaValidator->validate($dataInJson, $schema, JsonPointer::document())->isValid();
    }

    private function getSchema(string $name): Json|bool
    {
        $path = "{$this->parameterBag->get('kernel.project_dir')}/config/scheme/{$name}.json";

        if (file_exists($path)) {
            return Json::fromString(file_get_contents($path));
        }

        return false;
    }

    private function jsonIsValidated(mixed $data): bool
    {
        if (is_string($data)) {
            json_decode($data);

            return JSON_ERROR_NONE === json_last_error();
        }

        return true;
    }
}