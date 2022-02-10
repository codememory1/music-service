<?php

namespace App\Service\Translator\Language;

use App\DTO\LanguageDTO;
use App\Service\CRUD\UpdaterCRUDService;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UpdaterLanguageService
 *
 * @package App\Service\Translator\Language
 *
 * @author  Codememory
 */
class UpdaterLanguageService extends UpdaterCRUDService
{

    /**
     * @param LanguageDTO        $languageDTO
     * @param ValidatorInterface $validator
     * @param int                $id
     *
     * @return ApiResponseService
     * @throws Exception
     */
    public function update(LanguageDTO $languageDTO, ValidatorInterface $validator, int $id): ApiResponseService
    {

        $this->validator = $validator;
        $this->validateEntity = true;
        $this->messageNameNotExist = 'lang_not_exist';
        $this->translationKeyNotExist = 'lang@langNotExist';

        $updatedEntity = $this->make($languageDTO, ['id' => $id]);

        if ($updatedEntity instanceof ApiResponseService) {
            return $updatedEntity;
        }

        return $this->push($updatedEntity, 'lang@successUpdate', true);

    }

}