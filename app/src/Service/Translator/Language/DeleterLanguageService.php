<?php

namespace App\Service\Translator\Language;

use App\Entity\Language;
use App\Enums\ApiResponseTypeEnum;
use App\Repository\LanguageRepository;
use App\Service\AbstractApiService;
use App\Service\Response\ApiResponseService;
use Exception;

/**
 * Class DeleterLanguageService
 *
 * @package App\Service\Translator\Language
 *
 * @author  Codememory
 */
class DeleterLanguageService extends AbstractApiService
{

    /**
     * @param int      $id
     * @param callable $handler
     *
     * @return ApiResponseService
     * @throws Exception
     */
    public function delete(int $id, callable $handler): ApiResponseService
    {

        /** @var LanguageRepository $languageRepository */
        $languageRepository = $this->em->getRepository(Language::class);

        // Check exist language
        if (null === $finedLanguage = $languageRepository->findOneBy(['id' => $id])) {
            $this
                ->prepareApiResponse('error', 404)
                ->setMessage(
                    ApiResponseTypeEnum::CHECK_EXIST,
                    'lang_not_exist',
                    $this->getTranslation('lang@langNotExist')
                );

            return $this->getPreparedApiResponse();
        }

        // Calling an Extender Method
        return call_user_func($handler, $finedLanguage);

    }

}