<?php

namespace App\Service;

use Ergebnis\Json\Pointer\JsonPointer;
use Ergebnis\Json\SchemaValidator\Json;
use Ergebnis\Json\SchemaValidator\SchemaValidator;
use function is_array;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Class SchemaValidatorService.
 *
 * @package App\Service
 *
 * @author  Codememory
 */
class SchemaValidatorService
{
    /**
     * @var ParameterBagInterface
     */
    private ParameterBagInterface $parameterBag;

    /**
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    /**
     * @param string       $schemaName
     * @param array|string $data
     *
     * @return bool
     */
    public function validate(string $schemaName, array|string $data): bool
    {
        $validator = new SchemaValidator();
        $settings = Json::fromString(is_array($data) ? json_encode($data) : $data);
        $schema = $this->getSchema($schemaName);

        return false !== $schema && $validator->validate($settings, $schema, JsonPointer::document())->isValid();
    }

    /**
     * @param string $name
     *
     * @return bool|Json
     */
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
}