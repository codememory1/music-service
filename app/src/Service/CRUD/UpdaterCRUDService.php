<?php

namespace App\Service\CRUD;

use App\DTO\AbstractDTO;
use App\Entity\Translation;
use App\Enum\ApiResponseTypeEnum;
use App\Exception\UndefinedClassForDTOException;
use App\Interface\EntityInterface;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UpdaterCRUDService
 *
 * @package App\Service\CRUD
 *
 * @author  Codememory
 */
class UpdaterCRUDService extends AbstractCRUD
{

    /**
     * @var ValidatorInterface|null
     */
    protected ?ValidatorInterface $validator = null;

    /**
     * @var string|null
     */
    protected ?string $translationKeyNotExist = null;

    /**
     * @var string|null
     */
    protected ?string $messageNameNotExist = null;

    /**
     * @var bool
     */
    protected bool $validateEntity = false;

    /**
     * @var bool
     */
    protected bool $checkPermission = true;

    /**
     * @var EntityInterface|null
     */
    protected ?EntityInterface $finedEntity = null;

    /**
     * @inheritDoc
     * @throws UndefinedClassForDTOException
     * @throws Exception
     */
    protected function make(AbstractDTO|string $entityOrDTO, array $manipulationBy = []): ApiResponseService|EntityInterface
    {

        // Check exist translation
        $finedEntity = $this->exist($entityOrDTO, $manipulationBy);

        // Check for the existence of an entity
        if ($finedEntity instanceof ApiResponseService) {
            return $finedEntity;
        }

        $this->finedEntity = $finedEntity;

        // Checking the rights or whether the user is the owner of this entry
        $resultCheckPermission = $this->accessPermissionsCheck($finedEntity, $this->validator);

        if ($this->checkPermission && true !== $resultCheckPermission) {
            return $resultCheckPermission;
        }

        $collectedEntity = $entityOrDTO->update($finedEntity)->getCollectedEntity();

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

    /**
     * @param AbstractDTO $DTO
     * @param array       $manipulationBy
     *
     * @return ApiResponseService|Translation
     * @throws UndefinedClassForDTOException
     * @throws Exception
     */
    private function exist(AbstractDTO $DTO, array $manipulationBy): ApiResponseService|EntityInterface
    {

        $finedEntity = $this->getRepository($DTO)->findOneBy($manipulationBy);

        if (null === $finedEntity) {
            $preparedResponse = $this->prepareApiResponse('error', 404);

            $preparedResponse->setMessage(
                ApiResponseTypeEnum::CHECK_EXIST,
                $this->messageNameNotExist,
                $this->getTranslation($this->translationKeyNotExist)
            );

            return $this->getPreparedApiResponse();
        }

        return $finedEntity;

    }

}