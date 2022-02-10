<?php

namespace App\Service\Translator\Translation;

use App\DTO\TranslationDTO;
use App\Service\CRUD\UpdaterCRUDService;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UpdaterTranslationService
 *
 * @package App\Service\Translator\Translation
 *
 * @author  Codememory
 */
class UpdaterTranslationService extends UpdaterCRUDService
{

    /**
     * @param TranslationDTO     $translationDTO
     * @param ValidatorInterface $validator
     * @param int                $id
     *
     * @return ApiResponseService
     * @throws Exception
     */
    public function update(TranslationDTO $translationDTO, ValidatorInterface $validator, int $id): ApiResponseService
    {

        $this->validator = $validator;
        $this->validateEntity = true;
        $this->messageNameNotExist = 'translation_not_exist';
        $this->translationKeyNotExist = 'translation@notExist';

        $updatedEntity = $this->make($translationDTO, ['id' => $id]);

        if ($updatedEntity instanceof ApiResponseService) {
            return $updatedEntity;
        }

        return $this->push($updatedEntity, 'translation@successUpdate', true);

    }

}