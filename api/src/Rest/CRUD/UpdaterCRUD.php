<?php

namespace App\Rest\CRUD;

use App\Interfaces\DTOInterface;
use App\Interfaces\EntityInterface;
use App\Rest\Http\Response;

/**
 * Class UpdaterCRUD.
 *
 * @package App\Service\CRUD
 *
 * @author  Codememory
 */
class UpdaterCRUD extends AbstractCRUD
{
    /**
     * @var null|string
     */
    protected ?string $translationKeyNotExist = null;

    /**
     * @var bool
     */
    protected bool $validateEntity = false;

    /**
     * @var null|EntityInterface
     */
    protected ?EntityInterface $finedEntity = null;

    /**
     * @inheritDoc
     */
    protected function make(DTOInterface|string $entityOrDTO, array $manipulationBy = []): Response|EntityInterface
    {
        // Check exist translation
        $finedEntity = $this->exist($entityOrDTO, $manipulationBy);

        // Check for the existence of an entity
        if ($finedEntity instanceof Response) {
            return $finedEntity;
        }

        $this->finedEntity = $finedEntity;

        $collectedEntity = $entityOrDTO->setEntityForBuild($finedEntity)->getCollectedEntity();

        // Validation when inserting into the database
        if ($this->validateEntity) {
            $validator = $this->inputValidation($collectedEntity);

            if (!$validator->isValidate()) {
                return $validator->getResponse();
            }
        }

        return $collectedEntity;
    }

    /**
     * @param DTOInterface $DTO
     * @param array        $manipulationBy
     *
     * @return EntityInterface|Response
     */
    private function exist(DTOInterface $DTO, array $manipulationBy): Response|EntityInterface
    {
        $finedEntity = $this->getRepository($DTO)->findOneBy($manipulationBy);

        if (null === $finedEntity) {
            return $this->responseCollection->notExist($this->translationKeyNotExist)->getResponse();
        }

        return $finedEntity;
    }
}