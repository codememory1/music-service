<?php

namespace App\Service\Translator\Language;

use App\DTO\LanguageDTO;
use App\Exception\UndefinedClassForDTOException;
use App\Service\CRUD\CreatorCRUDService;
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
class CreatorLanguageService extends CreatorCRUDService
{

    /**
     * @param LanguageDTO        $languageDTO
     * @param ValidatorInterface $validator
     *
     * @return ApiResponseService
     * @throws UndefinedClassForDTOException
     * @throws Exception
     */
    public function create(LanguageDTO $languageDTO, ValidatorInterface $validator): ApiResponseService
    {

        $this->validator = $validator;
        $this->validateEntity = true;

        $createdLanguage = $this->make($languageDTO);

        if ($createdLanguage instanceof ApiResponseService) {
            return $createdLanguage;
        }

        return $this->push($createdLanguage, 'lang@successCreate');

    }

}