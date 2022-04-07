<?php

namespace App\Service\Translator\TranslationKey;

use App\DTO\TranslationKeyDTO;
use App\Entity\TranslationKey;
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

        /** @var TranslationKey|Response $createdTranslationKey */
        $createdTranslationKey = $this->make($translationKeyDTO);

        if ($createdTranslationKey instanceof Response) {
            return $createdTranslationKey;
        }

        return $this->manager->push($createdTranslationKey, 'translationKey@successCreate');
    }
}