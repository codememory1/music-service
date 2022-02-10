<?php

namespace App\Service\Translator\TranslationKey;

use App\DTO\TranslationKeyDTO;
use App\Exception\UndefinedClassForDTOException;
use App\Service\CRUD\UpdaterCRUDService;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UpdaterTranslationKeyService
 *
 * @package App\Service\Translator\TranslationKey
 *
 * @author  Codememory
 */
class UpdaterTranslationKeyService extends UpdaterCRUDService
{

    /**
     * @param TranslationKeyDTO  $translationKeyDTO
     * @param ValidatorInterface $validator
     * @param int                $id
     *
     * @return ApiResponseService
     * @throws UndefinedClassForDTOException
     * @throws Exception
     */
    public function update(TranslationKeyDTO $translationKeyDTO, ValidatorInterface $validator, int $id): ApiResponseService
    {

        $this->validator = $validator;
        $this->validateEntity = true;
        $this->messageNameNotExist = 'translation_key_not_exist';
        $this->translationKeyNotExist = 'translationKey@notExist';

        $updatedEntity = $this->make($translationKeyDTO, ['id' => $id]);

        if ($updatedEntity instanceof ApiResponseService) {
            return $updatedEntity;
        }

        return $this->push($updatedEntity, 'translationKey@successUpdate', true);

    }

}