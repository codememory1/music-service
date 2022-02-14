<?php

namespace App\Service\Translator\TranslationKey;

use App\Entity\TranslationKey;
use App\Service\CRUD\DeleterCRUDService;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class DeleterTranslationKeyService
 *
 * @package App\Service\Translator\TranslationKey
 *
 * @author  Codememory
 */
class DeleterTranslationKeyService extends DeleterCRUDService
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
        $this->messageNameNotExist = 'translation_key_not_exist';
        $this->translationKeyNotExist = 'translationKey@notExist';

        $deletedEntity = $this->make(TranslationKey::class, ['id' => $id]);

        if ($deletedEntity instanceof ApiResponseService) {
            return $deletedEntity;
        }

        return $this->remove($deletedEntity, 'translationKey@successDelete');

    }

}