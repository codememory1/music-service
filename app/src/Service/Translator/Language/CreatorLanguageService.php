<?php

namespace App\Service\Translator\Language;

use App\Entity\Language;
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
     * @param callable           $handler
     *
     * @return ApiResponseService
     * @throws Exception
     */
    public function create(ValidatorInterface $validator, callable $handler): ApiResponseService
    {

        $languageEntity = $this->collectEntity();

        // Input Validation
        if (true !== $resultInputValidation = $this->inputValidation($languageEntity, $validator)) {
            return $resultInputValidation;
        }

        // Calling an Extender Method
        return call_user_func($handler, $languageEntity);

    }

    /**
     * @return Language
     */
    private function collectEntity(): Language
    {

        $languageEntity = new Language();

        $languageEntity
            ->setCode($this->request->get('code', ''))
            ->setTitle($this->request->get('title', ''));

        return $languageEntity;

    }

}