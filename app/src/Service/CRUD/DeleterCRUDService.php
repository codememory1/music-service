<?php

namespace App\Service\CRUD;

use App\DTO\AbstractDTO;
use App\Enum\ApiResponseTypeEnum;
use App\Interface\EntityInterface;
use App\Service\Response\ApiResponseService;
use Exception;

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
     * @var string|null
     */
    protected ?string $translationKeyNotExist = null;

    /**
     * @var string|null
     */
    protected ?string $messageNameNotExist = null;

    /**
     * @inheritDoc
     * @throws Exception
     */
    protected function make(AbstractDTO|string $entityOrDTO, array $manipulationBy = []): ApiResponseService|EntityInterface
    {

        // Check for the existence of an entry
        if (null === $finedRecord = $this->getRepository($entityOrDTO)->findOneBy($manipulationBy)) {
            $preparedResponse = $this->prepareApiResponse('error', 404);

            $preparedResponse->setMessage(
                ApiResponseTypeEnum::CHECK_EXIST,
                $this->messageNameNotExist,
                $this->getTranslation($this->translationKeyNotExist)
            );

            return $this->getPreparedApiResponse();
        }

        return $finedRecord;

    }

}