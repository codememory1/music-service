<?php

namespace App\Service\CRUD;

use App\DTO\AbstractDTO;
use App\Exception\UndefinedClassForDTOException;
use App\Interface\EntityInterface;
use App\Service\AbstractApiService;
use App\Service\Response\ApiResponseService;
use Doctrine\Persistence\ObjectRepository;

/**
 * Class AbstractCRUD
 *
 * @package App\Service\CRUD
 *
 * @author  Codememory
 */
abstract class AbstractCRUD extends AbstractApiService
{

    /**
     * @param AbstractDTO|string $entityOrDTO
     *
     * @return ObjectRepository|null
     * @throws UndefinedClassForDTOException
     */
    protected function getRepository(AbstractDTO|string $entityOrDTO): ?ObjectRepository
    {

        if (is_string($entityOrDTO)) {
            return $this->em->getRepository($entityOrDTO);
        }

        $entity = $entityOrDTO->getCollectedEntity();

        return $this->em->getRepository($entity::class);

    }

    /**
     * @param AbstractDTO|string $entityOrDTO
     * @param array              $manipulationBy
     *
     * @return AbstractApiService|EntityInterface
     */
    abstract protected function make(AbstractDTO|string $entityOrDTO, array $manipulationBy = []): ApiResponseService|EntityInterface;

}