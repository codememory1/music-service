<?php

namespace App\Service;

use Ergebnis\Json\Pointer\JsonPointer;
use Ergebnis\Json\SchemaValidator\Json;
use Ergebnis\Json\SchemaValidator\SchemaValidator;
use function is_array;
use function is_string;
use const JSON_ERROR_NONE;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SchemaValidatorService
{
    public function __construct(
        private readonly ParameterBagInterface $parameterBag
    ) {}

    public function validate(string $schemaName, array|string $data): bool
    {
        $validator = new SchemaValidator();

        if (false === $this->isJson($data)) {
            return false;
        }

        $settings = Json::fromString(is_array($data) ? json_encode($data) : $data);
        $schema = $this->getSchema($schemaName);

        return false !== $schema && $validator->validate($settings, $schema, JsonPointer::document())->isValid();
    }

    private function getSchema(string $name): Json|bool
    {
        $path = sprintf(
            '%s/config/scheme/%s.json',
            $this->parameterBag->get('kernel.project_dir'),
            $name
        );

        if (file_exists($path)) {
            return Json::fromString(file_get_contents($path));
        }

        return false;
    }

    private function isJson(mixed $data): bool
    {
        if (is_string($data)) {
            json_decode($data);

            return JSON_ERROR_NONE === json_last_error();
        }

        return false;
    }
}