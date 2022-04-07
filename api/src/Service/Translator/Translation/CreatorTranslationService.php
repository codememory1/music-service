<?php

namespace App\Service\Translator\Translation;

use App\DTO\TranslationDTO;
use App\Entity\Translation;
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

        /** @var Translation|Response $createdTranslation */
        $createdTranslation = $this->make($translationDTO);

        if ($createdTranslation instanceof Response) {
            return $createdTranslation;
        }

        return $this->manager->push($createdTranslation, 'translation@successAdd');
    }
}