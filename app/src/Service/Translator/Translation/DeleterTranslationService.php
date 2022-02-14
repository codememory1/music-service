<?php

namespace App\Service\Translator\Translation;

use App\Entity\Translation;
use App\Service\CRUD\DeleterCRUDService;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class DeleterTranslationService
 *
 * @package App\Service\Translator\Translation
 *
 * @author  Codememory
 */
class DeleterTranslationService extends DeleterCRUDService
{

    /**
     * @param ValidatorInterface $validator
     * @param int                $id
     *
     * @return ApiResponseService
     * @throws Exception
     */
    public function delete(ValidatorInterface $validator, int $id): ApiResponseService
    {

        $this->validator = $validator;
        $this->messageNameNotExist = 'translation_not_exist';
        $this->translationKeyNotExist = 'translation@notExist';

        $deletedEntity = $this->make(Translation::class, ['id' => $id]);

        if ($deletedEntity instanceof ApiResponseService) {
            return $deletedEntity;
        }

        return $this->remove($deletedEntity, 'translation@notExist');

    }

}