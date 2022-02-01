<?php

namespace App\Service\Translator\Translation;

use App\Entity\Language;
use App\Entity\TranslationKey;
use App\Enums\ApiResponseTypeEnum;
use App\Repository\LanguageRepository;
use App\Repository\TranslationKeyRepository;
use App\Service\AbstractApiService;
use App\Service\Response\ApiResponseService;
use Exception;

/**
 * Class AbstractAddAndUpdateTranslation
 *
 * @package App\Service\Translator\Translation
 *
 * @author  Codememory
 */
abstract class AbstractAddAndUpdateTranslation extends AbstractApiService
{


    /**
     * @return Language|null
     * @throws Exception
     */
    protected function existLang(): ApiResponseService|Language
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
    protected function existTranslationKey(): ApiResponseService|TranslationKey
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

}