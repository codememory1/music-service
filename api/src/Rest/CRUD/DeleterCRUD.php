<?php

namespace App\Rest\CRUD;

use App\Interfaces\DTOInterface;
use App\Interfaces\EntityInterface;
use App\Rest\Http\Response;
use Exception;

/**
 * Class DeleterCRUD.
 *
 * @package App\Service\CRUD
 *
 * @author  Codememory
 */
class DeleterCRUD extends AbstractCRUD
{
    /**
     * @var null|string
     */
    protected ?string $translationKeyNotExist = null;

    /**
     * @inheritDoc
     *
     * @throws Exception
     */
    protected function make(DTOInterface|string $entityOrDTO, array $manipulationBy = []): Response|EntityInterface
    {
        $finedEntity = $this->getRepository($entityOrDTO)->findOneBy($manipulationBy);

        if (null === $finedEntity) {
            return $this->responseCollection
                ->notExist($this->translationKeyNotExist)
                ->getResponse();
        }

        return $finedEntity;
    }
}