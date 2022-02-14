<?php

namespace App\Service\Translator\Language;

use App\Entity\Language;
use App\Service\CRUD\DeleterCRUDService;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class DeleterLanguageService
 *
 * @package App\Service\Translator\Language
 *
 * @author  Codememory
 */
class DeleterLanguageService extends DeleterCRUDService
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
        $this->messageNameNotExist = 'lang_not_exist';
        $this->translationKeyNotExist = 'lang@langNotExist';

        $deletedEntity = $this->make(Language::class, ['id' => $id]);

        if ($deletedEntity instanceof ApiResponseService) {
            return $deletedEntity;
        }

        return $this->remove($deletedEntity, 'lang@successDelete');

    }

}