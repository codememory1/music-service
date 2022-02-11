<?php

namespace App\Service\CRUD;

use App\DTO\AbstractDTO;
use App\Exception\UndefinedClassForDTOException;
use App\Interface\EntityInterface;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CreatorCRUDService
 *
 * @package App\Service\CRUD
 *
 * @author  Codememory
 */
class CreatorCRUDService extends AbstractCRUD
{

    /**
     * @var ValidatorInterface|null
     */
    protected ?ValidatorInterface $validator = null;

    /**
     * @var bool
     */
    protected bool $validateEntity = false;

    /**
     * @var bool
     */
    protected bool $checkPermission = true;

    /**
     * @inheritDoc
     * @throws UndefinedClassForDTOException
     * @throws Exception
     */
    protected function make(AbstractDTO|string $entityOrDTO, array $manipulationBy = []): ApiResponseService|EntityInterface
    {

        $collectedEntity = $entityOrDTO->getCollectedEntity();

        // Checking the rights or whether the user is the owner of this entry
        $resultCheckPermission = $this->accessPermissionsCheck($collectedEntity, $this->validator);

        if ($this->checkPermission && true !== $resultCheckPermission) {
            return $resultCheckPermission;
        }

        // Validation of input POST data
        if (true !== $resultInputValidation = $this->inputValidation($entityOrDTO, $this->validator)) {
            return $resultInputValidation;
        }

        // Validation when inserting into the database
        if ($this->validateEntity) {
            if (true !== $resultInputValidation = $this->inputValidation($collectedEntity, $this->validator)) {
                return $resultInputValidation;
            }
        }

        return $collectedEntity;

    }

}