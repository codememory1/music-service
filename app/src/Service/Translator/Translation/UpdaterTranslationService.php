<?php

namespace App\Service\Translator\Translation;

use App\Entity\Language;
use App\Entity\Translation;
use App\Entity\TranslationKey;
use App\Enums\ApiResponseTypeEnum;
use App\Repository\TranslationRepository;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UpdaterTranslationService
 *
 * @package App\Service\Translator\Translation
 *
 * @author  Codememory
 */
class UpdaterTranslationService extends AbstractAddAndUpdateTranslation
{

    /**
     * @param int                $id
     * @param ValidatorInterface $validator
     * @param callable           $handler
     *
     * @return ApiResponseService
     * @throws Exception
     */
    public function update(int $id, ValidatorInterface $validator, callable $handler): ApiResponseService
    {

        /** @var TranslationRepository $translationRepository */
        $translationRepository = $this->em->getRepository(Translation::class);

        // Check exist language
        if (null === $finedTranslation = $translationRepository->findOneBy(['id' => $id])) {
            $this
                ->prepareApiResponse('error', 404)
                ->setMessage(
                    ApiResponseTypeEnum::CHECK_EXIST,
                    'translation_not_exist',
                    $this->getTranslation('translation@notExist')
                );

            return $this->getPreparedApiResponse();
        }

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

        $collectedEntity = $this->collectEntity($finedTranslation, $languageEntity, $translationKeyEntity);

        // Input validation
        if (true !== $resultInputValidation = $this->inputValidation($collectedEntity, $validator)) {
            return $resultInputValidation;
        }

        // Calling an Extender Method
        return call_user_func($handler, $collectedEntity);

    }

    /**
     * @param Translation    $translationEntity
     * @param Language       $languageEntity
     * @param TranslationKey $translationKeyEntity
     *
     * @return Translation
     */
    private function collectEntity(Translation $translationEntity, Language $languageEntity, TranslationKey $translationKeyEntity): Translation
    {

        $translationEntity
            ->setLang($languageEntity)
            ->setTranslationKey($translationKeyEntity)
            ->setTranslation($this->request->get('translation', ''));

        return $translationEntity;

    }

}