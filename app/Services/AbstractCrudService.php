<?php

namespace App\Services;

use Codememory\Components\Validator\Interfaces\ValidationBuildInterface;
use Codememory\Components\Validator\Interfaces\ValidationManagerInterface;
use Codememory\Components\Validator\Manager;
use ErrorException;

/**
 * Class AbstractCrudService
 *
 * @package App\Services
 *
 * @author  Danil
 */
abstract class AbstractCrudService extends AbstractApiService
{

    /**
     * @var ResponseApiCollectorService|null
     */
    protected ?ResponseApiCollectorService $responseApiCollectorService = null;

    /**
     * @return ResponseApiCollectorService
     * @throws ErrorException
     */
    final public function getResponseApiCollector(): ResponseApiCollectorService
    {

        if (null === $this->responseApiCollectorService) {
            throw new ErrorException(sprintf('No response for service %s', static::class));
        }

        return $this->responseApiCollectorService;

    }

    /**
     * @param ResponseApiCollectorService $responseApiCollectorService
     *
     * @return $this
     */
    final public function setResponse(ResponseApiCollectorService $responseApiCollectorService): static
    {

        $this->responseApiCollectorService = $responseApiCollectorService;

        return $this;

    }

    /**
     * @param Manager                  $manager
     * @param ValidationBuildInterface $validationBuild
     *
     * @return ValidationManagerInterface
     */
    protected function makeInputValidation(Manager $manager, ValidationBuildInterface $validationBuild): ValidationManagerInterface
    {

        return $manager->create($validationBuild, $this->request->post()->all());

    }

}