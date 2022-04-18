<?php

namespace App\Rest\CRUD;

use App\Interfaces\DTOInterface;
use App\Interfaces\EntityInterface;
use App\Rest\Http\Response;

/**
 * Class CreatorCRUD.
 *
 * @package App\Service\CRUD
 *
 * @author  Codememory
 */
class CreatorCRUD extends AbstractCRUD
{
    /**
     * @var bool
     */
    protected bool $validateEntity = false;

    /**
     * @inheritDoc
     */
    protected function make(DTOInterface|string $entityOrDTO, array $manipulationBy = []): Response|EntityInterface
    {
        $collectedEntity = $entityOrDTO->getCollectedEntity();

        // Validation when inserting into the database
        if ($this->validateEntity) {
            $validator = $this->inputValidation($collectedEntity);

            if (!$validator->isValidate()) {
                return $validator->getResponse();
            }
        }

        return $collectedEntity;
    }
}