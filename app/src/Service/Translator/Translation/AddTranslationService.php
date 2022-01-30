<?php

namespace App\Service\Translator\Translation;

use App\Entity\Language;
use App\Entity\Translation;
use App\Entity\TranslationKey;
use App\Enums\ApiResponseTypeEnum;
use App\Repository\LanguageRepository;
use App\Repository\TranslationKeyRepository;
use App\Repository\TranslationRepository;
use App\Service\AbstractApiService;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AddTranslationService
 *
 * @package App\Service\Translator\Translation
 *
 * @author  Codememory
 */
class AddTranslationService extends AbstractApiService
{

    /**
     * @param ValidatorInterface $validator
     *
     * @return ApiResponseService
     * @throws Exception
     */
    public function add(ValidatorInterface $validator): ApiResponseService
    {

        /** @var TranslationRepository $translationRepository */
        $translationRepository = $this->em->getRepository(Translation::class);

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

        $translationByLangAndKey = $translationRepository->findOneBy([
            'lang'           => $languageEntity,
            'translationKey' => $translationKeyEntity,
        ]);

        // Checking if a translation exists for the selected language
        if (null !== $translationByLangAndKey) {
            $this
                ->prepareApiResponse('error', 404)
                ->setMessage(
                    ApiResponseTypeEnum::CHECK_EXIST,
                    'lang_not_exist',
                    $this->getTranslation('translation@exist')
                );

            return $this->getPreparedApiResponse();
        }

        $collectedEntity = $this->collectEntity($languageEntity, $translationKeyEntity);

        // Input validation
        if (true !== $resultInputValidation = $this->inputValidation($collectedEntity, $validator)) {
            return $resultInputValidation;
        }

        // Adding a translation to the database
        return $this->push($collectedEntity, 'translation@successAdd');

    }

    /**
     * @return Language|null
     * @throws Exception
     */
    private function existLang(): ApiResponseService|Language
    {

        /** @var LanguageRepository $languageRepository */
        $languageRepository = $this->em->getRepository(Language::class);
        $finedLanguage = $languageRepository->findOneBy([
            'code' => $this->request->get('lang_code')
        ]);

        if (null === $finedLanguage) {
            $this
                ->prepareApiResponse('error', 404)
                ->setMessage(
                    ApiResponseTypeEnum::CHECK_EXIST,
                    'lang_not_exist',
                    $this->getTranslation('lang@langNotExist')
                );

            return $this->getPreparedApiResponse();
        }

        return $finedLanguage;

    }

    /**
     * @return TranslationKey|null
     * @throws Exception
     */
    private function existTranslationKey(): ApiResponseService|TranslationKey
    {

        /** @var TranslationKeyRepository $translationKeyRepository */
        $translationKeyRepository = $this->em->getRepository(TranslationKey::class);
        $finedTranslationKey = $translationKeyRepository->findOneBy([
            'name' => $this->request->get('translation_key')
        ]);

        if (null === $finedTranslationKey) {
            $this
                ->prepareApiResponse('error', 404)
                ->setMessage(
                    ApiResponseTypeEnum::CHECK_EXIST,
                    'translation_key_not_exist',
                    $this->getTranslation('translationKey@notExist')
                );

            return $this->getPreparedApiResponse();
        }

        return $finedTranslationKey;

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