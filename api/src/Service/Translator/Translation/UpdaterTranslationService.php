<?php

namespace App\Service\Translator\Translation;

use App\DTO\TranslationDTO;
use App\Entity\Translation;
use App\Rest\CRUD\UpdaterCRUD;
use App\Rest\Http\Response;

/**
 * Class UpdaterTranslationService.
 *
 * @package App\Service\Translator\Translation
 *
 * @author  Codememory
 */
class UpdaterTranslationService extends UpdaterCRUD
{
    /**
     * @param TranslationDTO $translationDTO
     * @param int            $id
     *
     * @return Response
     */
    public function update(TranslationDTO $translationDTO, int $id): Response
    {
        $this->validateEntity = true;
        $this->translationKeyNotExist = 'translation@notExist';

        /** @var Translation|Response $updatedTranslation */
        $updatedTranslation = $this->make($translationDTO, ['id' => $id]);

        if ($updatedTranslation instanceof Response) {
            return $updatedTranslation;
        }

        return $this->manager->update($updatedTranslation, 'translation@successUpdate');
    }
}