<?php

namespace App\Service\Translator\Translation;

use App\DTO\TranslationDTO;
use App\Rest\CRUD\CreatorCRUD;
use App\Rest\Http\Response;

/**
 * Class CreatorTranslationService.
 *
 * @package App\Service\Translator\Translation
 *
 * @author  Codememory
 */
class CreatorTranslationService extends CreatorCRUD
{
    /**
     * @param TranslationDTO $translationDTO
     *
     * @return Response
     */
    public function create(TranslationDTO $translationDTO): Response
    {
        $this->validateEntity = true;

        $createdEntity = $this->make($translationDTO);

        if ($createdEntity instanceof Response) {
            return $createdEntity;
        }

        return $this->manager->push($createdEntity, 'translation@successAdd');
    }
}