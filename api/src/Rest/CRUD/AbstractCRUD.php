<?php

namespace App\Rest\CRUD;

use App\Interfaces\DTOInterface;
use App\Interfaces\EntityInterface;
use App\Rest\ApiService;
use App\Rest\Http\Response;
use Doctrine\Persistence\ObjectRepository;
use function is_string;

/**
 * Class AbstractCRUD.
 *
 * @package App\Service\CRUD
 *
 * @author  Codememory
 */
abstract class AbstractCRUD extends ApiService
{
    /**
     * @param DTOInterface|string $entityOrDTO
     * @param array               $manipulationBy
     *
     * @return EntityInterface|Response
     */
    abstract protected function make(DTOInterface|string $entityOrDTO, array $manipulationBy = []): Response|EntityInterface;

    /**
     * @param DTOInterface|string $entityOrDTO
     *
     * @return null|ObjectRepository
     */
    protected function getRepository(DTOInterface|string $entityOrDTO): ?ObjectRepository
    {
        if (is_string($entityOrDTO)) {
            return $this->em->getRepository($entityOrDTO);
        }

        $entity = $entityOrDTO->getCollectedEntity();

        return $this->em->getRepository($entity::class);
    }
}