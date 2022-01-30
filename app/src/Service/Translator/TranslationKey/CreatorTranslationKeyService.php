<?php

namespace App\Service\Translator\TranslationKey;

use App\Entity\TranslationKey;
use App\Service\AbstractApiService;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CreatorTranslationKeyService
 *
 * @package App\Service\Translator\TranslationKey
 *
 * @author  Codememory
 */
class CreatorTranslationKeyService extends AbstractApiService
{

    /**
     * @param ValidatorInterface $validator
     * @param callable           $handler
     *
     * @return ApiResponseService
     * @throws Exception
     */
    public function create(ValidatorInterface $validator, callable $handler): ApiResponseService
    {

        $collectedEntity = $this->collectEntity();

        // Input Validation
        if (true !== $resultInputValidation = $this->inputValidation($collectedEntity, $validator)) {
            return $resultInputValidation;
        }

        // Calling an Extender Method
        return call_user_func($handler, $collectedEntity);

    }

    /**
     * @return TranslationKey
     */
    private function collectEntity(): TranslationKey
    {

        $translationKeyEntity = new TranslationKey();

        $translationKeyEntity->setName($this->request->get('name', ''));

        return $translationKeyEntity;

    }

}