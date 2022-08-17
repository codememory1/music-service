<?php

namespace App\Service\DataRepresentation;

use App\Rest\Http\Request;
use Ergebnis\Json\Pointer\JsonPointer;
use Ergebnis\Json\SchemaValidator\Json;
use Ergebnis\Json\SchemaValidator\SchemaValidator;
use function is_array;
use LogicException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

abstract class AbstractDataRepresentation
{
    protected ?string $keyName = null;
    protected ?string $schemaName = null;
    protected readonly array $dataRepresentation;
    private Request $request;
    private ParameterBagInterface $parameterBag;

    public function __construct(Request $request, ParameterBagInterface $parameterBag)
    {
        $this->request = $request;
        $this->parameterBag = $parameterBag;

        $this->dataRepresentation = $this->collectSettings();
    }

    abstract public function get(string $name): mixed;

    abstract public function exist(string $name): bool;

    public function all(): array
    {
        return $this->dataRepresentation;
    }

    private function collectSettings(): array
    {
        if (null === $this->keyName) {
            throw new LogicException(sprintf('The name of the key with the settings for data representation in the %s class is not set', static::class));
        }

        $validator = new SchemaValidator();
        $settings = Json::fromString(json_encode(array_values($this->getSettings())));
        $schema = $this->getSchema();

        if (false !== $schema && $validator->validate($settings, $schema, JsonPointer::document())->isValid()) {
            return json_decode($settings->toString(), true);
        }

        return [];
    }

    private function getSettings(): array
    {
        $settings = $this->request->getRequest()?->query->all()[$this->keyName] ?? false;

        if (false === $settings || false === is_array($settings)) {
            return [];
        }

        return $settings;
    }

    private function getSchema(): Json|bool
    {
        $path = sprintf(
            '%s/config/scheme/%s.json',
            $this->parameterBag->get('kernel.project_dir'),
            $this->schemaName
        );

        if (file_exists($path)) {
            return Json::fromString(file_get_contents($path));
        }

        return false;
    }
}