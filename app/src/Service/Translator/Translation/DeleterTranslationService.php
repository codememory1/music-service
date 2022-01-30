<?php

namespace App\Service\Translator\Translation;

use App\Entity\Translation;
use App\Enums\ApiResponseTypeEnum;
use App\Repository\TranslationRepository;
use App\Service\AbstractApiService;
use App\Service\Response\ApiResponseService;
use Exception;

/**
 * Class DeleterTranslationService
 *
 * @package App\Service\Translator\Translation
 *
 * @author  Codememory
 */
class DeleterTranslationService extends AbstractApiService
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

        // Calling an Extender Method
        return call_user_func($handler, $finedTranslation);

    }

}