<?php

namespace App\Service\Translator\Language;

use App\DTO\LanguageDTO;
use App\Entity\Language;
use App\Rest\CRUD\CreatorCRUD;
use App\Rest\Http\Response;

/**
 * Class CreatorLanguageService.
 *
 * @package App\Service\Translator\Language
 *
 * @author  Codememory
 */
class CreatorLanguageService extends CreatorCRUD
{
    /**
     * @param LanguageDTO $languageDTO
     *
     * @return Response
     */
    public function create(LanguageDTO $languageDTO): Response
    {
        $this->validateEntity = true;

        /** @var Language|Response $createdLanguage */
        $createdLanguage = $this->make($languageDTO);

        if ($createdLanguage instanceof Response) {
            return $createdLanguage;
        }

        return $this->manager->push($createdLanguage, 'lang@successCreate');
    }
}