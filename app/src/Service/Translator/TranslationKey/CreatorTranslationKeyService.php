<?php

namespace App\Service\Translator\TranslationKey;

use App\DTO\TranslationKeyDTO;
use App\Rest\CRUD\CreatorCRUD;
use App\Rest\Http\Response;

/**
 * Class CreatorTranslationKeyService.
 *
 * @package App\Service\Translator\TranslationKey
 *
 * @author  Codememory
 */
class CreatorTranslationKeyService extends CreatorCRUD
{
    /**
     * @param TranslationKeyDTO $translationKeyDTO
     *
     * @return Response
     */
    public function create(TranslationKeyDTO $translationKeyDTO): Response
    {
        $this->validateEntity = true;

        $createdEntity = $this->make($translationKeyDTO);

        if ($createdEntity instanceof Response) {
            return $createdEntity;
        }

        return $this->manager->push($createdEntity, 'translationKey@successCreate');
    }
}