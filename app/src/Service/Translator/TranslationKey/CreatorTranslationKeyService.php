<?php

namespace App\Service\Translator\TranslationKey;

use App\DTO\TranslationKeyDTO;
use App\Service\CRUD\CreatorCRUDService;
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
class CreatorTranslationKeyService extends CreatorCRUDService
{

    /**
     * @param TranslationKeyDTO  $translationKeyDTO
     * @param ValidatorInterface $validator
     *
     * @return ApiResponseService
     * @throws Exception
     */
    public function create(TranslationKeyDTO $translationKeyDTO, ValidatorInterface $validator): ApiResponseService
    {

        $this->validator = $validator;
        $this->validateEntity = true;

        $createdEntity = $this->make($translationKeyDTO);

        if ($createdEntity instanceof ApiResponseService) {
            return $createdEntity;
        }

        return $this->push($createdEntity, 'translationKey@successCreate');

    }

}