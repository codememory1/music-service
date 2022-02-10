<?php

namespace App\Service\Translator\Translation;

use App\DTO\TranslationDTO;
use App\Exception\UndefinedClassForDTOException;
use App\Service\CRUD\CreatorCRUDService;
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
class CreatorTranslationService extends CreatorCRUDService
{

    /**
     * @param TranslationDTO     $translationDTO
     * @param ValidatorInterface $validator
     *
     * @return ApiResponseService
     * @throws UndefinedClassForDTOException
     * @throws Exception
     */
    public function create(TranslationDTO $translationDTO, ValidatorInterface $validator): ApiResponseService
    {

        $this->validator = $validator;
        $this->validateEntity = true;

        $createdEntity = $this->make($translationDTO);

        if ($createdEntity instanceof ApiResponseService) {
            return $createdEntity;
        }

        return $this->push($createdEntity, 'translation@successAdd');

    }

}