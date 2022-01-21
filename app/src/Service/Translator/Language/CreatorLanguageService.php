<?php

namespace App\Service\Translator\Language;

use App\Entity\Language;
use App\Enums\ApiResponseTypeEnum;
use App\Service\AbstractApiService;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CreatorLanguageService
 *
 * @package App\Service\Translator\Language
 *
 * @author  Codememory
 */
class CreatorLanguageService extends AbstractApiService
{

    /**
     * @param ValidatorInterface $validator
     *
     * @return ApiResponseService
     * @throws Exception
     */
    public function create(ValidatorInterface $validator): ApiResponseService
    {

        $languageEntity = new Language();

        $languageEntity
            ->setCode($this->request->get('code', ''))
            ->setTitleTranslationKey($this->request->get('title', ''));

        // Input Validation
        if (count($errors = $validator->validate($languageEntity)) > 0) {
            $validateInfo = $this->getValidateInfo($errors);

            $this->prepareApiResponse('error', 400)
                ->setMessage(
                    ApiResponseTypeEnum::INPUT_VALIDATION,
                    $validateInfo['name'],
                    $this->getTranslation($validateInfo['message'])
                );

            return $this->getPreparedApiResponse();
        }

        // Saving data to the database
        return $this->push($languageEntity);

    }

    /**
     * @param Language $languageEntity
     *
     * @return ApiResponseService
     * @throws Exception
     */
    private function push(Language $languageEntity): ApiResponseService
    {

        $this->em->persist($languageEntity);
        $this->em->flush();

        $this->prepareApiResponse('success', 200)
            ->setMessage(
                ApiResponseTypeEnum::CREATE,
                'success_create',
                $this->getTranslation('lang@successCreate')
            );

        return $this->getPreparedApiResponse();

    }

}