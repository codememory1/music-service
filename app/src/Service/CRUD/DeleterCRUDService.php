<?php

namespace App\Service\CRUD;

use App\DTO\AbstractDTO;
use App\Enum\ApiResponseTypeEnum;
use App\Exception\UndefinedClassForDTOException;
use App\Interface\EntityInterface;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class DeleterCRUDService
 *
 * @package App\Service\CRUD
 *
 * @author  Codememory
 */
class DeleterCRUDService extends AbstractCRUD
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
    protected bool $checkPermission = true;

    /**
     * @inheritDoc
     * @throws Exception
     */
    protected function make(AbstractDTO|string $entityOrDTO, array $manipulationBy = []): ApiResponseService|EntityInterface
    {

        // Check for the existence of an entry
        $finedEntity = $this->exist($entityOrDTO, $manipulationBy);

        if ($finedEntity instanceof ApiResponseService) {
            return $finedEntity;
        }

        // Checking the rights or whether the user is the owner of this entry
        $resultCheckPermission = $this->accessPermissionsCheck($finedEntity, $this->validator);

        if ($this->checkPermission && true !== $resultCheckPermission) {
            return $resultCheckPermission;
        }

        return $finedEntity;

    }

    /**
     * @param AbstractDTO|string $entityOrDTO
     * @param array              $manipulationBy
     *
     * @return EntityInterface|ApiResponseService
     * @throws UndefinedClassForDTOException
     * @throws Exception
     */
    private function exist(AbstractDTO|string $entityOrDTO, array $manipulationBy): EntityInterface|ApiResponseService
    {

        $finedEntity = $this->getRepository($entityOrDTO)->findOneBy($manipulationBy);

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