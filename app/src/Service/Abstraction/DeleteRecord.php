<?php

namespace App\Service\Abstraction;

use App\Enums\ApiResponseTypeEnum;
use App\Service\Response\ApiResponseService;
use Exception;

/**
 * Class DeleteRecord
 *
 * @package App\Service\Abstraction
 *
 * @author  Codememory
 */
class DeleteRecord extends AbstractAbstraction
{

    /**
     * @param int    $id
     * @param string $messageName
     * @param string $translationKeyNotExist
     *
     * @return ApiResponseService
     * @throws Exception
     */
    public function make(int $id, string $messageName, string $translationKeyNotExist): ApiResponseService
    {

        $entityRepository = $this->em->getRepository($this->entityNamespace);

        // Check exist translation key
        if (null === $finedRecord = $entityRepository->findOneBy(['id' => $id])) {
            $this
                ->prepareApiResponse('error', 404)
                ->setMessage(
                    ApiResponseTypeEnum::CHECK_EXIST,
                    $messageName,
                    $this->getTranslation($translationKeyNotExist)
                );

            return $this->getPreparedApiResponse();
        }

        // Calling an Extender Method
        return call_user_func($this->handler, $finedRecord);

    }

}