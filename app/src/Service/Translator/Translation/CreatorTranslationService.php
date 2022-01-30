<?php

namespace App\Service\Translator\Translation;

use App\Entity\Language;
use App\Entity\Translation;
use App\Entity\TranslationKey;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CreatorTranslationService
 *
 * @package App\Service\Translator\Translation
 *
 * @author  Codememory
 */
class CreatorTranslationService extends AbstractAddAndUpdateTranslation
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

        // Checking for Language Existence
        if ($languageEntity = $this->existLang()) {
            if ($languageEntity instanceof ApiResponseService) {
                return $languageEntity;
            }
        }

        // Checking for the existence of a translation key
        if ($translationKeyEntity = $this->existTranslationKey()) {
            if ($translationKeyEntity instanceof ApiResponseService) {
                return $translationKeyEntity;
            }
        }

        $collectedEntity = $this->collectEntity($languageEntity, $translationKeyEntity);

        // Input validation
        if (true !== $resultInputValidation = $this->inputValidation($collectedEntity, $validator)) {
            return $resultInputValidation;
        }

        // Extender method call
        return call_user_func($handler, $collectedEntity);

    }

    /**
     * @param Language       $languageEntity
     * @param TranslationKey $translationKeyEntity
     *
     * @return Translation
     */
    private function collectEntity(Language $languageEntity, TranslationKey $translationKeyEntity): Translation
    {

        $translationEntity = new Translation();

        $translationEntity
            ->setLang($languageEntity)
            ->setTranslationKey($translationKeyEntity)
            ->setTranslation($this->request->get('translation', ''));

        return $translationEntity;

    }

}